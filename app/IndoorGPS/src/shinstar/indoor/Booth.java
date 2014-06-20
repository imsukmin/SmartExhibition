package shinstar.indoor;

public class Booth {
	final static int NumberOfAP=3;
	private int index;
	private String apLevelList;
	private int apLevel[] = new int[NumberOfAP];
	private double distance;

	public Booth(int index, String apLevelList) {
		this.index = index;
		this.apLevelList = apLevelList;
	}

	public String getApLevelList() {
		return apLevelList;
	}

	public void setApLevel(int level1, int level2, int level3) {
		this.apLevel[0] = level1;
		this.apLevel[1] = level2;
		this.apLevel[2] = level3;
	}

	public int getIndex() {
		return index;
	}

	public int[] getApLevel() {
		return apLevel;
	}

	public void setDistance(double distance) {
		this.distance = distance;
	}

	public double getDistance() {
		return distance;
	}
}