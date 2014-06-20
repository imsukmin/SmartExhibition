package com.googry.android.exhibitionadministrator;

import java.util.ArrayList;
import java.util.List;

import shinstar.indoor.APLevel;
import shinstar.indoor.APLevelCalculator;
import android.app.Activity;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.googry.android.exhibitionadministrator.data.Exhibition;
import com.googry.android.exhibitionadministrator.data.ExhibitionDataManager;
import com.googry.android.exhibitionadministrator.server.PushWebServer;

public class ManagerActivity extends Activity implements OnClickListener {

	// NFC
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;
	private String str_tvNfcTagId;
	private String str_pushTagMsg;
	private ArrayList<String> str_NfcTagId;
	private int exhibitionPosition;
	private TextView tv_newTagId, tv_tagIdStoredServer;
	private Exhibition exhibition;
	private Button btn_clear, btn_submit;

	// WIFI
	private WifiManager wifimanager;
	private int scanCount = 0;
	private List<ScanResult> mScanResult; // ScanResult List
	private EditText et_apMacAddress1, et_apMacAddress2, et_apMacAddress3;
	private Button btn_apMacAddressEdit1, btn_apMacAddressEdit2,
			btn_apMacAddressEdit3;
	private ProgressBar pb_wifiScan;
	private Button btn_wifiScan;
	private Button btn_wifiSubmit;
	private ArrayList<String> alMacAddress;
	private boolean prevOffWifi = false;
	private APLevelCalculator apLevelCalculator;
	private ArrayList<APLevel> apLevels;
	private static final int REQUESTCODE1 = 1, REQUESTCODE2 = 2,
			REQUESTCODE3 = 3;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_manager);

		setData();
		setId();
		setListener();

		// nfc
		setNFC();

		// wifi
		setWIFI();
	}

	private void setData() {
		// Return selected position;
		Intent intent = getIntent();
		exhibitionPosition = intent.getIntExtra("exhibitionPosition", -1);
		// if exhibitionPosition value is -1 this is error value
		if (exhibitionPosition == -1) {
			Toast.makeText(getBaseContext(), "Exhibition Position Error",
					Toast.LENGTH_LONG).show();
			finish();
		}
		// set title text
		exhibition = ExhibitionDataManager.getInstance().getAlExhibition()
				.get(exhibitionPosition - 1);
		String str_title = exhibitionPosition + exhibition.getProductName();
		setTitle(str_title);

		// NFC
		str_NfcTagId = new ArrayList<String>();
		str_tvNfcTagId = "";
		str_pushTagMsg = "";

		// WIFI
		String _APs = exhibition.getApLevel();

		alMacAddress = new ArrayList<String>();
		if (!_APs.isEmpty()) {
			String _AP[] = _APs.split("/");
			if (_AP.length == 3) {
				for (String temp : _AP) {
					alMacAddress.add(temp.split(",")[0]);
				}
			}
		}

	}

	private void setId() {
		btn_clear = (Button) findViewById(R.id.btn_clear);
		btn_submit = (Button) findViewById(R.id.btn_nfcSubmit);
		tv_newTagId = (TextView) findViewById(R.id.tv_newTagId);
		tv_tagIdStoredServer = (TextView) findViewById(R.id.tv_tagIdStoredServer);
		et_apMacAddress1 = (EditText) findViewById(R.id.et_apMacAddress1);
		et_apMacAddress2 = (EditText) findViewById(R.id.et_apMacAddress2);
		et_apMacAddress3 = (EditText) findViewById(R.id.et_apMacAddress3);
		btn_apMacAddressEdit1 = (Button) findViewById(R.id.btn_apMacAddressEdit1);
		btn_apMacAddressEdit2 = (Button) findViewById(R.id.btn_apMacAddressEdit2);
		btn_apMacAddressEdit3 = (Button) findViewById(R.id.btn_apMacAddressEdit3);
		pb_wifiScan = (ProgressBar) findViewById(R.id.pb_wifiScan);
		btn_wifiScan = (Button) findViewById(R.id.btn_wifiScan);
		btn_wifiSubmit = (Button) findViewById(R.id.btn_wifiSubmit);
	}

	private void setListener() {
		btn_clear.setOnClickListener(this);
		btn_submit.setOnClickListener(this);
		btn_apMacAddressEdit1.setOnClickListener(this);
		btn_apMacAddressEdit2.setOnClickListener(this);
		btn_apMacAddressEdit3.setOnClickListener(this);
		btn_wifiScan.setOnClickListener(this);
		btn_wifiSubmit.setOnClickListener(this);
	}

	private void setNFC() {
		if (exhibition.getNfcTagId().length != 0) {
			String tagIdStoredServer = "";
			for (String str : exhibition.getNfcTagId()) {
				tagIdStoredServer += str + "\n";
			}

			tv_tagIdStoredServer.setText(tagIdStoredServer);
		}
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
	}

	private void setWIFI() {
		wifimanager = (WifiManager) getSystemService(WIFI_SERVICE);
		if (alMacAddress.size() == 3) {
			et_apMacAddress1.setText(alMacAddress.get(0));
			et_apMacAddress2.setText(alMacAddress.get(1));
			et_apMacAddress3.setText(alMacAddress.get(2));
		}

		// 추후 변경
		pb_wifiScan.setMax(10);
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
		super.onPause();
	}

	// Detect Nfc
	@Override
	protected void onNewIntent(Intent intent) {
		super.onNewIntent(intent);
		Tag tag = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
		if (tag != null) {
			byte[] tagId = tag.getId();
			String str_tag = toHexString(tagId);

			int loop = str_NfcTagId.size();
			int i;
			for (i = 0; i < loop; i++) {
				if (str_NfcTagId.get(i).equals(str_tag)) {
					break;
				}
			}
			if (i == loop) {
				Toast.makeText(getBaseContext(), "Taging", Toast.LENGTH_LONG)
						.show();
				str_tvNfcTagId += str_tag + "\n";
				str_NfcTagId.add(str_tag);
			} else {
				Toast.makeText(getBaseContext(), "Already Taging",
						Toast.LENGTH_LONG).show();
			}

			tv_newTagId.setText(str_tvNfcTagId);
		}
	}

	private final String CHARS = "0123456789ABCDEF";

	private String toHexString(byte[] data) {
		StringBuilder sb = new StringBuilder();
		for (int i = 0; i < data.length; ++i) {
			sb.append(CHARS.charAt((data[i] >> 4) & 0x0F)).append(
					CHARS.charAt(data[i] & 0x0F));
		}
		return sb.toString();
	}

	@Override
	public void onClick(View v) {
		Intent intent = null;
		switch (v.getId()) {
		case R.id.btn_clear:
			str_tvNfcTagId = "";
			tv_newTagId.setText("EMPTY");
			str_NfcTagId.clear();
			break;
		case R.id.btn_nfcSubmit:
			// if str_NfcTagId not empty
			if (str_NfcTagId.size() != 0) {
				// make str_pushTagMsg
				str_pushTagMsg += str_NfcTagId.get(0);
				int loop = str_NfcTagId.size();
				for (int i = 1; i < loop; i++) {
					str_pushTagMsg += "," + str_NfcTagId.get(i);
				}

			} else {
				str_pushTagMsg = "";
			}

			// make str_pushServerMsg
			String str_pushServerNfcMsg = String.format(
					"registerNFC?index=%d&nfcID=%s", exhibitionPosition,
					str_pushTagMsg);
			PushWebServer pwsNfc = new PushWebServer();
			pwsNfc.setPushMsg(str_pushServerNfcMsg);
			pwsNfc.start();
			// Change Value of NfcTagId
			exhibition.setNfcTagId(str_pushTagMsg.split(","));
			finish();
			break;
		case R.id.btn_apMacAddressEdit1:
			intent = new Intent(ManagerActivity.this,
					WifiApMacAddressActivity.class);
			startActivityForResult(intent, REQUESTCODE1);
			break;
		case R.id.btn_apMacAddressEdit2:
			intent = new Intent(ManagerActivity.this,
					WifiApMacAddressActivity.class);
			startActivityForResult(intent, REQUESTCODE2);
			break;
		case R.id.btn_apMacAddressEdit3:
			intent = new Intent(ManagerActivity.this,
					WifiApMacAddressActivity.class);
			startActivityForResult(intent, REQUESTCODE3);
			break;
		case R.id.btn_wifiScan:
			initWIFIScan();
			break;
		case R.id.btn_wifiSubmit:
			String str_pushWifiMsg = "";
			str_pushWifiMsg += apLevels.get(0).getBssid() + ","
					+ apLevels.get(0).getApLevel();
			for (int i = 1; i < apLevels.size(); i++) {
				str_pushWifiMsg += "/" + apLevels.get(i).getBssid() + ","
						+ apLevels.get(i).getApLevel();
			}
			Toast.makeText(getBaseContext(), "Submit", Toast.LENGTH_LONG)
					.show();
			// make str_pushServerMsg
			String str_pushServerWifilMsg = String.format(
					"registerAP?index=%d&AP=%s", exhibitionPosition,
					str_pushWifiMsg);
			PushWebServer pwsWifi = new PushWebServer();
			pwsWifi.setPushMsg(str_pushServerWifilMsg);
			pwsWifi.start();
			// Change Value of ApLevel
			exhibition.setApLevel(str_pushWifiMsg);
			finish();
		}
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
		if (resultCode == RESULT_OK) {
			String macAddr;
			switch (requestCode) {
			case REQUESTCODE1:
				macAddr = data.getStringExtra("macAddr");
				alMacAddress.set(0, macAddr);
				et_apMacAddress1.setText(macAddr);
				break;
			case REQUESTCODE2:
				macAddr = data.getStringExtra("macAddr");
				alMacAddress.set(1, macAddr);
				et_apMacAddress2.setText(macAddr);
				break;
			case REQUESTCODE3:
				macAddr = data.getStringExtra("macAddr");
				alMacAddress.set(2, macAddr);
				et_apMacAddress3.setText(macAddr);
				break;
			}
		}
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

	public void getWIFIScanResult() {

		mScanResult = wifimanager.getScanResults(); // ScanResult
		// Scan count
		scanCount++;
		pb_wifiScan.setProgress(scanCount);
		apLevelCalculator.addAPList(mScanResult);
		if (scanCount == pb_wifiScan.getMax()) {

			if (wifimanager.isWifiEnabled() && prevOffWifi)
				wifimanager.setWifiEnabled(false);
			unregisterReceiver(mReceiver);
			Toast.makeText(getBaseContext(), "WIFI Scan Complete",
					Toast.LENGTH_SHORT).show();

			apLevels = apLevelCalculator.calculateAPLevel();

		}
	}

	public void initWIFIScan() {
		if (alMacAddress.size() == 3) {
			apLevelCalculator = new APLevelCalculator();
			for (String bssid : alMacAddress)
				apLevelCalculator.addAPBSSID(bssid);
			// init WIFISCAN
			if (wifimanager.isWifiEnabled() == false) {
				prevOffWifi = true;
				wifimanager.setWifiEnabled(true);
			} else {
				prevOffWifi = false;
			}

			scanCount = 0;

			final IntentFilter filter = new IntentFilter(
					WifiManager.SCAN_RESULTS_AVAILABLE_ACTION);
			filter.addAction(WifiManager.NETWORK_STATE_CHANGED_ACTION);
			registerReceiver(mReceiver, filter);
			wifimanager.startScan();
			Toast.makeText(getBaseContext(), "Wifi Scan Start",
					Toast.LENGTH_SHORT).show();
		} else {
			Toast.makeText(getBaseContext(), "Value lack", Toast.LENGTH_SHORT)
					.show();
		}

	}
}
