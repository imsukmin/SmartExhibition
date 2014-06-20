package com.googry.android.gradproj.data;

public class ExhibitionCheckIn {
	private int index;
	private String userID;
	private String checkIn;

	public ExhibitionCheckIn(int index, String userID, String checkIn) {
		this.index = index;
		this.userID = userID;
		this.checkIn = checkIn;
	}

	public int getIndex() {
		return index;
	}

	public String getUserID() {
		return userID;
	}

	public String getCheckIn() {
		return checkIn;
	}

}
