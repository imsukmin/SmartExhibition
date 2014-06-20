package com.googry.android.exhibitionadministrator.server;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class JsonParser {
	public static String[][] jsonBoothListParser(String pRecvServerPage) {

		try {
			JSONArray ja = new JSONArray(pRecvServerPage);
			String[] jsonName = { "index", "teamName", "productName",
					"professor", "member", "outline", "target", "homepage",
					"brochure", "nfcTagId", "apLevel", "summary" };
			String[][] parseredData = new String[ja.length()][jsonName.length];
			for (int i = 0; i < ja.length(); i++) {
				JSONObject json = ja.getJSONObject(i);
				for (int j = 0; j < jsonName.length; j++) {
					parseredData[i][j] = json.getString(jsonName[j]);
				}
			}
			return parseredData;
		} catch (JSONException e) {
			e.printStackTrace();
			return null;
		}
	}

	public static String[][] jsonAPListParser(String pRecvServerPage) {

		try {
			JSONArray ja = new JSONArray(pRecvServerPage);
			String[] jsonName = { "index", "macAddress", "x", "y" };
			String[][] parseredData = new String[ja.length()][jsonName.length];
			for (int i = 0; i < ja.length(); i++) {
				JSONObject json = ja.getJSONObject(i);
				for (int j = 0; j < jsonName.length; j++) {
					parseredData[i][j] = json.getString(jsonName[j]);
				}
			}
			return parseredData;
		} catch (JSONException e) {
			e.printStackTrace();
			return null;
		}
	}

	public static String[][] jsonRankParser(String pRecvServerPage) {

		try {
			JSONArray ja = new JSONArray(pRecvServerPage);
			String[] jsonName = { "index", "count" };
			String[][] parseredData = new String[ja.length()][jsonName.length];
			for (int i = 0; i < ja.length(); i++) {
				JSONObject json = ja.getJSONObject(i);
				for (int j = 0; j < jsonName.length; j++) {
					parseredData[i][j] = json.getString(jsonName[j]);
				}
			}
			return parseredData;
		} catch (JSONException e) {
			e.printStackTrace();
			return null;
		}
	}
}
