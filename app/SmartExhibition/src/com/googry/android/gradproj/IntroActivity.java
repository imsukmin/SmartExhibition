package com.googry.android.gradproj;

import java.util.ArrayList;
import java.util.Calendar;

import shinstar.indoor.AP;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.provider.Settings.Secure;
import android.util.Log;

import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.server.RequestWebServer;
import com.googry.android.gradproj.server.RequestWebServer.GetServerJsonMessage;

public class IntroActivity extends Activity {

	private Handler h;
	private ArrayList<Exhibition> alEx;
	private ArrayList<AP> alAP;
	private RequestWebServer webServer;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stubs
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_intro);
		makeData();
		h = new Handler();
	}

	private void makeData() {
		ExhibitionDataManager ehDataManager = ExhibitionDataManager
				.getInstance();
		alEx = ehDataManager.getAlExhibition();
		alEx.clear();
		alAP = ehDataManager.getAlAP();
		alAP.clear();

		String androidId = Secure.getString(getContentResolver(),
				Secure.ANDROID_ID);
		ehDataManager.setAndroidId(androidId);

		webServer = new RequestWebServer();
		webServer.setMsgs(ExhibitionDataManager.BOOTHINFO,
				ExhibitionDataManager.GETAP);
		webServer.start();
		webServer.setOnGetServerJsonMessageListener(new GetServerJsonMessage() {

			@Override
			public void onGetServerMsg(String requestCode,
					String[][] parserString) {
				if (requestCode.equals(ExhibitionDataManager.BOOTHINFO)) {
					for (int i = 0; i < parserString.length; i++) {
						alEx.add(new Exhibition(Integer
								.parseInt(parserString[i][0]),
								parserString[i][1], parserString[i][2],
								parserString[i][3], parserString[i][4],
								parserString[i][5], parserString[i][6],
								parserString[i][7], parserString[i][8],
								parserString[i][9].split(","),
								parserString[i][10], parserString[i][11]));
					}
				} else if (requestCode.equals(ExhibitionDataManager.GETAP)) {
					for (int i = 0; i < parserString.length; i++) {
						AP _ap = new AP(parserString[i][1]);
						_ap.setLocation(Integer.parseInt(parserString[i][2]),
								Integer.parseInt(parserString[i][3]));
						alAP.add(_ap);
					}
					h.postDelayed(irun, 500);
				}
			}
		});

	}

	Runnable irun = new Runnable() {
		public void run() {
			Intent i = new Intent(IntroActivity.this,
					ExhibitionListActivity.class);
			startActivity(i);
			finish();

			overridePendingTransition(android.R.anim.fade_in,
					android.R.anim.fade_out);
		}

	};

	@Override
	public void onBackPressed() {
		// TODO Auto-generated method stub
		super.onBackPressed();
		h.removeCallbacks(irun);
	}

}
