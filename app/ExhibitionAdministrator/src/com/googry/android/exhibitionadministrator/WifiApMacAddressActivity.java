package com.googry.android.exhibitionadministrator;

import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;

import com.googry.android.exhibitionadministrator.adapter.WifiApMacAddressAdapter;
import com.googry.android.exhibitionadministrator.data.WifiApMacAddress;

public class WifiApMacAddressActivity extends Activity {
	WifiManager wifimanager;
	private List<ScanResult> mScanResult; // ScanResult List
	private boolean prevOffWifi = false;

	private ArrayList<WifiApMacAddress> alWAMA;
	private ListView lv_apMacAddress;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_wifiapmacaddress);
		initWIFIScan();
	}

	// Detect Wifi
	private BroadcastReceiver mReceiver = new BroadcastReceiver() {
		@Override
		public void onReceive(Context context, Intent intent) {
			final String action = intent.getAction();
			if (action.equals(WifiManager.SCAN_RESULTS_AVAILABLE_ACTION)) {
				getWIFIScanResult(); // get WIFISCanResult
			} else if (action.equals(WifiManager.NETWORK_STATE_CHANGED_ACTION)) {
				sendBroadcast(new Intent("wifi.ON_NETWORK_STATE_CHANGED"));
			}
		}
	};

	// wifi result process
	public void getWIFIScanResult() {

		mScanResult = wifimanager.getScanResults(); // ScanResult
		alWAMA = new ArrayList<WifiApMacAddress>();
		for (ScanResult sr : mScanResult) {
			alWAMA.add(new WifiApMacAddress(sr.SSID, sr.BSSID, sr.level));
		}

		lv_apMacAddress = (ListView) findViewById(R.id.lv_apMacAddress);
		WifiApMacAddressAdapter wamaAdapter = new WifiApMacAddressAdapter(
				getBaseContext(), R.layout.row_wifiapmacaddress, alWAMA);
		lv_apMacAddress.setAdapter(wamaAdapter);
		lv_apMacAddress.setOnItemClickListener(new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent = getIntent();
				intent.putExtra("macAddr", alWAMA.get(position).getBSSID());
				setResult(RESULT_OK,intent);
				finish();
			}
		});
		unregisterReceiver(mReceiver);
		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() && prevOffWifi)
			wifimanager.setWifiEnabled(false);

	}

	public void initWIFIScan() {
		// Setup WIFI
		wifimanager = (WifiManager) getSystemService(WIFI_SERVICE);

		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() == false) {
			prevOffWifi = true;
			wifimanager.setWifiEnabled(true);
		} else {
			prevOffWifi = false;
		}
		// init WIFISCAN
		final IntentFilter filter = new IntentFilter(
				WifiManager.SCAN_RESULTS_AVAILABLE_ACTION);
		filter.addAction(WifiManager.NETWORK_STATE_CHANGED_ACTION);
		registerReceiver(mReceiver, filter);
		wifimanager.startScan();
	}
}
