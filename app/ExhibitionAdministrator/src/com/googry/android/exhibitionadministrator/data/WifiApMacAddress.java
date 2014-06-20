package com.googry.android.exhibitionadministrator.data;

public class WifiApMacAddress {
	private String SSID;
	private String BSSID;
	private int apLevel;

	public WifiApMacAddress(String SSID, String BSSID, int apLevel) {
		this.SSID = SSID;
		this.BSSID = BSSID;
		this.apLevel = apLevel;
	}

	public String getSSID() {
		return SSID;
	}

	public String getBSSID() {
		return BSSID;
	}

	public int getApLevel() {
		return apLevel;
	}

}
