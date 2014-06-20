package shinstar.indoor;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

import android.net.wifi.ScanResult;

public class APLevelCalculator {
	private ArrayList<APLevel> apLevel = new ArrayList<APLevel>();
	private int count = 0;
	final static int RepeatCount=10;
	final static int DifferenceValue=10;
	
	public APLevelCalculator(){
		
	}
	//사용할 AP의 BSSID 값을 넣어준다.
	public void addAPBSSID(String BSSID){
		apLevel.add(new APLevel(BSSID));		
	}
	//반복해서 측정된 APLevel값을 ScanResult를 써서 넣어준다. 총 10번 받아오도록 세팅
	public boolean addAPList(List<ScanResult> scanlist){
		for(int i=0;i<scanlist.size();i++){
			for(int j=0;j<apLevel.size();j++){
				if(scanlist.get(i).BSSID.equals(apLevel.get(j).getBssid())){
					apLevel.get(j).addAPLevelInApLevelList(scanlist.get(i).level);
				}
			}
		}
		count++;
		if(count<RepeatCount)
			return true;
		else
			return false;
	}
	//APLevel class를 ArrayList로 반환한다.
	public ArrayList<APLevel> calculateAPLevel(){
		for(int i=0;i<apLevel.size();i++){
			if(apLevel.get(i).getApLevelList().size()!=0){
				ArrayList<Integer> apLevelList = apLevel.get(i).getApLevelList();
				int sum=0;
				//오름차순으로 정렬
				Collections.sort(apLevelList);
				//가장 작은 값과 가장 큰값이 그 전 값과 값이 10이상 차이나는지 비교하여 제거
				if(apLevelList.size()>2){
					if(apLevelList.get(1)-apLevelList.get(0)>DifferenceValue)
						apLevelList.remove(0);
					if(apLevelList.get(apLevelList.size()-1)-apLevelList.get(apLevelList.size()-2)>DifferenceValue)
						apLevelList.remove(apLevelList.size()-1);			
				}
				//편균값을 도출
				for(int j=0;j<apLevelList.size();j++){
					sum += apLevelList.get(j);
				}
				apLevel.get(i).setApLevel(sum/apLevelList.size());
			}
		}
		return apLevel;
	}

}

