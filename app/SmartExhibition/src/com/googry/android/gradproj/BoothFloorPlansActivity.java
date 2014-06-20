package com.googry.android.gradproj;

import java.util.ArrayList;
import java.util.List;

import shinstar.indoor.AP;
import shinstar.indoor.Booth;
import shinstar.indoor.IndoorGPS;
import android.app.Activity;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.Configuration;
import android.graphics.Point;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.util.DisplayMetrics;
import android.util.Log;

import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.view.BoothFloorPlansCustomView;

public class BoothFloorPlansActivity extends Activity {

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;

	// WifiManger variable
	private WifiManager wifimanager;
	private List<ScanResult> mScanResult; // ScanResult List
	private boolean prevOffWifi = false;
	private IndoorGPS indoorGPS;

	// view
	private BoothFloorPlansCustomView view;

	//
	private ArrayList<Exhibition> alExhibition;

	// test variable
	private int x = 100;
	private int y = 100;

	private int screenWidth;
	private int screenHeight;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_boothfloorplans);
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
		// ------------------------

		alExhibition = ExhibitionDataManager.getInstance().getAlExhibition();
		// wifi
		setWIFI();

		DisplayMetrics metrics = new DisplayMetrics();
		getWindowManager().getDefaultDisplay().getMetrics(metrics);
		screenWidth = metrics.widthPixels;
		screenHeight = metrics.heightPixels;

		view = (BoothFloorPlansCustomView) findViewById(R.id.boothFloorPlansCustomView);
	}

	private void convertPointPixel2Meter(Point point) {
		int x = point.x;
		int y = point.y;
		point.x = (int) ((double) (ExhibitionDataManager.CONVERTPHONEWIDTH * x) / ExhibitionDataManager.CONVERTMAPWIDTH);
		point.y = (int) ((double) (ExhibitionDataManager.CONVERTPHONEHEIGHT * y) / ExhibitionDataManager.CONVERTMAPHEIGHT);
	}

	private void convertPoint(Point point) {
		int x = point.x;
		int y = point.y;
		point.x = (int) ((double) (screenWidth * x) / ExhibitionDataManager.CONVERTPHONEWIDTH);
		point.y = (int) ((double) (screenHeight * y) / ExhibitionDataManager.CONVERTPHONEHEIGHT);
	}

	private void addBlankPoint(Point point) {
		int x = point.x;
		int y = point.y;
		double screenRatio = (screenWidth / screenHeight);
		double mapRatio = (ExhibitionDataManager.CONVERTMAPWIDTH / ExhibitionDataManager.CONVERTMAPHEIGHT);
		int blank;
		if (screenRatio > mapRatio) {
			// a>b 가로가 남음
			blank = (int) ((screenWidth - ((double) (ExhibitionDataManager.CONVERTMAPWIDTH * screenHeight) / ExhibitionDataManager.CONVERTMAPHEIGHT)) / 2);
			point.x = x + blank;
		} else {
			// a<b 세로가 남
			blank = (int) ((screenHeight - ((double) (ExhibitionDataManager.CONVERTMAPHEIGHT * screenWidth) / ExhibitionDataManager.CONVERTMAPWIDTH)) / 2);
			point.y = y + blank;
		}
	}

	private void setWIFI() {
		wifimanager = (WifiManager) getSystemService(WIFI_SERVICE);
		// AP
		ArrayList<AP> alAP = ExhibitionDataManager.getInstance().getAlAP();

		// Booth
		ArrayList<Booth> alBooth = new ArrayList<Booth>();
		for (int i = 0; i < alExhibition.size(); i++) {
			Exhibition tempEx = alExhibition.get(i);
			alBooth.add(new Booth(i, tempEx.getApLevel()));
		}

		// IndoorGPS
		indoorGPS = new IndoorGPS();
		indoorGPS.setApList(alAP);
		indoorGPS.setBoothList(alBooth);
		initWIFIScan();
	}

	private BroadcastReceiver mReceiver = new BroadcastReceiver() {
		@Override
		public void onReceive(Context context, Intent intent) {
			final String action = intent.getAction();
			if (action.equals(WifiManager.SCAN_RESULTS_AVAILABLE_ACTION)) {
				getWIFIScanResult(); // get WIFISCanResult
				wifimanager.startScan(); // for refresh
			} else if (action.equals(WifiManager.NETWORK_STATE_CHANGED_ACTION)) {
				sendBroadcast(new Intent("wifi.ON_NETWORK_STATE_CHANGED"));
				getWIFIScanResult(); // get WIFISCanResult
				wifimanager.startScan(); // for refresh
			}
		}
	};

	// wifi result process
	public void getWIFIScanResult() {

		mScanResult = wifimanager.getScanResults(); // ScanResult
		if(mScanResult == null)
			return;
		if (indoorGPS.setScanList(mScanResult)) {
			// set Client Position in BoothFloorPlansCustomView.java
			Point clientPoint = new Point();
			clientPoint.set((int) (indoorGPS.getX() * 100),
					(int) (indoorGPS.getY() * 100));
			convertPointPixel2Meter(clientPoint);
			convertPoint(clientPoint);
			addBlankPoint(clientPoint);
			view.invalidatePoint(clientPoint);
		}

	}

	public void initWIFIScan() {
		// init WIFISCAN
		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() == false) {
			prevOffWifi = true;
			wifimanager.setWifiEnabled(true);
		} else {
			prevOffWifi = false;
		}
		final IntentFilter filter = new IntentFilter(
				WifiManager.SCAN_RESULTS_AVAILABLE_ACTION);
		filter.addAction(WifiManager.NETWORK_STATE_CHANGED_ACTION);
		registerReceiver(mReceiver, filter);
		wifimanager.startScan();
	}

	@Override
	protected void onResume() {
		super.onResume();
		if (nfcAdapter != null) {
			nfcAdapter
					.enableForegroundDispatch(this, pendingIntent, null, null);
		}
	}

	@Override
	protected void onPause() {
		if (nfcAdapter != null) {
			nfcAdapter.disableForegroundDispatch(this);
		}
		unregisterReceiver(mReceiver);
		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() && prevOffWifi)
			wifimanager.setWifiEnabled(false);
		super.onPause();
	}

	// Detect Nfc
	@Override
	protected void onNewIntent(Intent intent) {
		super.onNewIntent(intent);
		Tag tag = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
		if (tag != null) {
		}
	}

}
