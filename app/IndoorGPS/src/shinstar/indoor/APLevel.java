package shinstar.indoor;

import java.util.ArrayList;

public class APLevel{
	private String bssid;
	private ArrayList<Integer> apLevelList;
	private int apLevel; //최종 평균 Level값
	public APLevel(String bssid){
		this.bssid = bssid;
		apLevelList = new ArrayList<Integer>();
		apLevel=0;
	}
	
	public void addAPLevelInApLevelList(int level){
		apLevelList.add(level);
	}

	public int getApLevel() {
		return apLevel;
	}

	public void setApLevel(int apLevel) {
		this.apLevel = apLevel;
	}

	public String getBssid() {
		return bssid;
	}

	public ArrayList<Integer> getApLevelList() {
		return apLevelList;
	}
	
	
}