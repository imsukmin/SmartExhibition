package shinstar.indoor;

public class AP {
	private String bssid;
	private int level, x, y;

	public AP(String bssid) {
		this.bssid = bssid;
	}

	public void setLevel(int level) {
		this.level = level;
	}

	public void setLocation(int x, int y) {
		this.x = x;
		this.y = y;
	}

	public int getX() {
		return x;
	}

	public int getY() {
		return y;
	}

	public String getBssid() {
		return bssid;
	}

	public int getLevel() {
		return level;
	}
}