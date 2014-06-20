package com.googry.android.gradproj.data;

import java.util.ArrayList;

import shinstar.indoor.AP;

public class ExhibitionDataManager {
	private static ExhibitionDataManager instance;
	private ArrayList<Exhibition> alExhibition;
	private ArrayList<AP> alAP;
	private String androidId;
	public static final String BOOTHINFO = "BoothInfo";
	public static final String GETAP = "getAP";
	public static final String SHOWRANKING = "showRanking";
	public static final String CHECKININFO = "checkinINFO";
	public static final int MAPBLANKWIDTH = 53;
	public static final int MAPBLANKHEIGHT = 78;
	
	public static final int CONVERTMAPWIDTH = 2800;
	public static final int CONVERTMAPHEIGHT = 1600;
	public static final int CONVERTPHONEWIDTH = 1920;
	public static final int CONVERTPHONEHEIGHT = 1080;

	public ArrayList<AP> getAlAP() {
		return alAP;
	}

	private ExhibitionDataManager() {
		alExhibition = new ArrayList<Exhibition>();
		alAP = new ArrayList<AP>();
	}

	public static ExhibitionDataManager getInstance() {
		if (instance == null) {
			instance = new ExhibitionDataManager();
		}
		return instance;
	}

	public ArrayList<Exhibition> getAlExhibition() {
		return alExhibition;
	}

	public String getAndroidId() {
		return androidId;
	}

	public void setAndroidId(String androidId) {
		this.androidId = androidId;
	}
}
