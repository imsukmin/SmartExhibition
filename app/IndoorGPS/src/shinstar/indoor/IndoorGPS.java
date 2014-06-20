package shinstar.indoor;
import java.util.ArrayList;
import java.util.List;

import android.net.wifi.ScanResult;

public class IndoorGPS {
	private List<ScanResult> scanList;
	private ArrayList<AP> apList;
	private ArrayList<Booth> boothList;
	private AP ap[] = new AP[3];
	private double x,y;

	public IndoorGPS() {
		apList = new ArrayList<AP>();
		boothList = new ArrayList<Booth>();
	}

	//모든 AP의 BSSID를 받아와 저장 (서버에서 받아옴) 
	public void setApList(ArrayList<AP> apList) {
		this.apList=apList;
	}	
	//부스의 index와 부스위치에서 측정되는 모든 level값(즉 부스 위치를 알수 있는 값)을 받아와 저장 (서버에서 받아옴) 
	//index는 부스이름 aplevel은 (BSSID1,level값:BSSID2,level값:BSSID3,level값:BSSID4,level값)형태의 String값	
	public void setBoothList(ArrayList<Booth> boothList) {
		this.boothList=boothList;
	}
	//사용자의 위치에서 측정된 모든 AP level 신호값을 받아와 저장 
	public boolean setScanList(List<ScanResult> scan) {
		scanList = scan;
		for (int i = 0, k = 0; i < scanList.size(); i++) {
			for (int j = 0; j < apList.size(); j++) {
				if (scanList.get(i).BSSID.equals(apList.get(j).getBssid())) {
					ap[k] = apList.get(j);
					ap[k].setLevel(scanList.get(i).level);
					if (k == 2) {
						setBoothApLevel();
						getBoothDistance();
						return true;
					}
					k++;
				}
			}
		}
		return false;
	}
	//각 부스에 저장된 AP level값 중 setAPLevel()에서 뽑아낸 3개의 AP의 level 값만 따로 저장
	private void setBoothApLevel() {
		for (int i = 0; i < boothList.size(); i++) {
			String level[] = new String[3];
			String aplevellist[] = boothList.get(i).getApLevelList().split("/");
			for (int j = 0; j < aplevellist.length; j++) {
				String aplevel[] = aplevellist[j].split(",");
				for (int k = 0; k < 3; k++) {
					if (aplevel[0].equals(this.ap[k].getBssid())) {
						level[k] = aplevel[1];
					}
				}
			}
			boothList.get(i).setApLevel(Integer.parseInt(level[0]),
					Integer.parseInt(level[1]), Integer.parseInt(level[2]));
		}
	}
	//사용자 위치에서 각 부스와의 거리를 계산
	
	private void getBoothDistance() {
		double d = 0;
		double x1, y1;
		double x2, y2;
		double x3, y3;
		double a1, b1;
		double a2, b2;
		double d1 = ap[0].getLevel(), d2 = ap[1].getLevel(), d3 = ap[2]
				.getLevel();
		
		x1 = ap[0].getX();
		y1 = ap[0].getY();
		x2 = ap[1].getX();
		y2 = ap[1].getY();
		x3 = ap[2].getX();
		y3 = ap[2].getY();
		
		d1 = Math.pow(2.72,(d1+33.66+d)/(-12.1));
		d2 = Math.pow(2.72,(d2+33.66+d)/(-12.1));
		d3 = Math.pow(2.72,(d3+33.66+d)/(-12.1));

		int status = 0;
		
		if(y1==y3){
			if(y1==y2){
				double temp;
				temp=y1;
				y1=y2;
				y2=temp;
				temp=x1;
				x1=x2;
				x2=temp;
				temp=d1;
				d1=d2;
				d2=temp;
				status=1;
			}else{
				double temp;
				temp=y3;
				y3=y2;
				y2=temp;
				temp=x3;
				x3=x2;
				x2=temp;
				temp=d3;
				d3=d2;
				d2=temp;
				status=2;
			}			
		}
		a1 = ((d1 * d1) - (d2 * d2)
				- ((y2 - y1) * ((d1 * d1) - (d3 * d3)) / (y3 - y1)) - (x1 * x1)
				+ (x2 * x2) - (y1 * y1) + (y2 * y2) + (((x1 * x1) - (x3 * x3)
				+ (y1 * y1) - (y3 * y3))
				* (y2 - y1) / (y3 - y1)))
				/ ((2 * x2) - (2 * x1) - ((y2 - y1) * ((2 * x3) - (2 * x1)) / (y3 - y1)));
		if (((d1 * d1) - ((x1 - a1) * (x1 - a1))) < 0)
			b1 = y1;
		else {
			b1 = y1 - Math.sqrt((d1 * d1) - ((x1 - a1) * (x1 - a1)));

			int plus = Math
					.abs((int) (((y1 - b1) * (y1 - b1)) + ((x1 - a1) * (x1 - a1)))
							- (int) (d1 * d1))
					+ Math.abs((int) (((y2 - b1) * (y2 - b1)) + ((x2 - a1) * (x2 - a1)))
							- (int) (d2 * d2))
					+ Math.abs((int) (((y3 - b1) * (y3 - b1)) + ((x3 - a1) * (x3 - a1)))
							- (int) (d3 * d3));
			int minus = Math
					.abs((int) (((y1 + b1) * (y1 + b1)) + ((x1 - a1) * (x1 - a1)))
							- (int) (d1 * d1))
					+ Math.abs((int) (((y2 + b1) * (y2 + b1)) + ((x2 - a1) * (x2 - a1)))
							- (int) (d2 * d2))
					+ Math.abs((int) (((y3 + b1) * (y3 + b1)) + ((x3 - a1) * (x3 - a1)))
							- (int) (d3 * d3));

			if (minus < plus) {
				b1 =  y1 + Math.sqrt((d1 * d1) - ((x1 - a1) * (x1 - a1)));
			}

		}
		this.x=23.8075 - b1;
		this.y=14.4625 - a1;

		for (int i = 0; i < boothList.size(); i++) {
			d1 = boothList.get(i).getApLevel()[0];
			d2 = boothList.get(i).getApLevel()[1];
			d3 = boothList.get(i).getApLevel()[2];

			d1 = Math.pow(2.72,(d1+33.66+d)/(-12.1));
			d2 = Math.pow(2.72,(d2+33.66+d)/(-12.1));
			d3 = Math.pow(2.72,(d3+33.66+d)/(-12.1));

			if(status==1){
					double temp;
					temp=d1;
					d1=d2;
					d2=temp;
			}else if(status==2){
					double temp;
					temp=d3;
					d3=d2;
					d2=temp;
			}			
			
			a2 = ((d1 * d1) - (d2 * d2)
					- ((y2 - y1) * ((d1 * d1) - (d3 * d3)) / (y3 - y1))
					- (x1 * x1) + (x2 * x2) - (y1 * y1) + (y2 * y2) + (((x1 * x1)
					- (x3 * x3) + (y1 * y1) - (y3 * y3))
					* (y2 - y1) / (y3 - y1)))
					/ ((2 * x2) - (2 * x1) - ((y2 - y1) * ((2 * x3) - (2 * x1)) / (y3 - y1)));
			if (((d1 * d1) - ((x1 - a2) * (x1 - a2))) < 0)
				b2 = y1;
			else {
				b2 = y1 - Math.sqrt((d1 * d1) - ((x1 - a2) * (x1 - a2)));

				int plus = Math
						.abs((int) (((y1 - b2) * (y1 - b2)) + ((x1 - a2) * (x1 - a2)))
								- (int) (d1 * d1))
						+ Math.abs((int) (((y2 - b2) * (y2 - b2)) + ((x2 - a2) * (x2 - a2)))
								- (int) (d2 * d2))
						+ Math.abs((int) (((y3 - b2) * (y3 - b2)) + ((x3 - a2) * (x3 - a2)))
								- (int) (d3 * d3));
				int minus = Math
						.abs((int) (((y1 + b2) * (y1 + b2)) + ((x1 - a2) * (x1 - a2)))
								- (int) (d1 * d1))
						+ Math.abs((int) (((y2 + b2) * (y2 + b2)) + ((x2 - a2) * (x2 - a2)))
								- (int) (d2 * d2))
						+ Math.abs((int) (((y3 + b2) * (y3 + b2)) + ((x3 - a2) * (x3 - a2)))
								- (int) (d3 * d3));

				if (minus < plus) {
					b2 = y1 + Math.sqrt((d1 * d1) - ((x1 - a2) * (x1 - a2)));
				}
			}
			boothList.get(i)
					.setDistance(
							Math.sqrt(((a1 - a2) * (a1 - a2))
									+ ((b1 - b2) * (b1 - b2))));
		}
	}
	public double getX(){
		return this.x;
	}
	public double getY(){
		return this.y;
	}
	//거리가 계산된 부스중 가장 가까운 부스 5개만 뽑아내어 return
	public ArrayList<Integer> getBoothList() {
		
		int _loop = boothList.size();
		for (int i = _loop+1; i > 0; i--) {
			for (int j = 1; j < (_loop); j++) { 
				if (boothList.get(j).getDistance() < boothList.get(j-1).getDistance()) {
					Booth k = boothList.get(j); 
					Booth k2 = boothList.get(j-1); 
					boothList.remove(j);
					boothList.add(j, k2); 
					boothList.remove(j-1);
					boothList.add(j-1, k);
				}
			}
		}
		ArrayList<Integer> nearboothList = new ArrayList<Integer>();
		if(_loop>4) _loop=4;
		for(int i = 0;i<_loop;i++){
			nearboothList.add(boothList.get(i).getIndex());
		}
		
		return nearboothList;
	}

}



