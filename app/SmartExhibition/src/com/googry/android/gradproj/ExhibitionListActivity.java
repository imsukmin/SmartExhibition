package com.googry.android.gradproj;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import shinstar.indoor.AP;
import shinstar.indoor.Booth;
import shinstar.indoor.IndoorGPS;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnClickListener;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.Configuration;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.widget.DrawerLayout;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import com.googry.android.gradproj.adapter.ExhibitionAdapter;
import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.server.PushWebServer;

public class ExhibitionListActivity extends Activity {
	// NavigationDrawer varialbe
	private ArrayList<String> navItems;
	private ListView lvNavList;
	private ListView lv_exhibition_custom_list;
	private ArrayList<Exhibition> alExhibition;
	private DrawerLayout dlDrawer;
	private ActionBarDrawerToggle dtToggle;

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;

	// WifiManager variable
	WifiManager wifimanager;
	private boolean prevOffWifi = false;
	private IndoorGPS indoorGPS;
	private ProgressDialog wifiProgressDialog;

	// ScanResult List
	private List<ScanResult> mScanResult;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_exhibitionlist);
		// NavigationDrawerList
		setNavigationDrawerList();

		// Exhibition List
		setExhibitionList();

		// NavigationDrawer
		setNavigationDrawer();

		// Wifi
		setWifi();

		// NFC
		setNfc();
	}

	private void setNavigationDrawerList() {
		navItems = new ArrayList<String>();
		navItems.add(getString(R.string.str_nearBoothCurrentState));
		navItems.add(getString(R.string.str_checkInBoothChecking));
		navItems.add(getString(R.string.str_seeBoothRanking));
		navItems.add(getString(R.string.str_boothFloorPlans));
		lvNavList = (ListView) findViewById(R.id.lv_activity_main_nav_list);
		lvNavList.setAdapter(new ArrayAdapter<String>(this,
				android.R.layout.simple_list_item_1, navItems));
		lvNavList.setOnItemClickListener(new DrawerItemClickListener());
	}

	private void setExhibitionList() {
		lv_exhibition_custom_list = (ListView) findViewById(R.id.lv_exhibition_custom_list);
		alExhibition = ExhibitionDataManager.getInstance().getAlExhibition();
		ExhibitionAdapter m_adapter = new ExhibitionAdapter(this,
				R.layout.row_exhibitionlist, alExhibition);

		lv_exhibition_custom_list.setAdapter(m_adapter);
		lv_exhibition_custom_list
				.setOnItemClickListener(new OnItemClickListener() {
					@Override
					public void onItemClick(AdapterView<?> parent, View view,
							int position, long id) {
						Intent intent = new Intent(ExhibitionListActivity.this,
								ExhibitionActivity.class);
						intent.putExtra("selectNum", position);
						startActivity(intent);
					}
				});
	}

	private void setNavigationDrawer() {
		dlDrawer = (DrawerLayout) findViewById(R.id.dl_activity_main_drawer);
		dtToggle = new ActionBarDrawerToggle(this, dlDrawer,
				R.drawable.ic_drawer, R.string.open_drawer,
				R.string.close_drawer) {

		};
		dlDrawer.setDrawerListener(dtToggle);
		getActionBar().setDisplayHomeAsUpEnabled(true);
	}

	private void setWifi() {
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

		// wifiProgressDialog
		wifiProgressDialog = new ProgressDialog(this);
		wifiProgressDialog.setTitle("Scan Wifi");
		wifiProgressDialog.setMessage("현재 사용자의 위치를 찾는 중입니다...");
	}

	private void startScanWifi() {
		// Setup WIFI
		wifimanager = (WifiManager) getSystemService(WIFI_SERVICE);

		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() == false) {
			prevOffWifi = true;
			wifimanager.setWifiEnabled(true);
		} else {
			prevOffWifi = false;
		}

		// wifi scan
		initWIFIScan(); // start WIFIScan
	}

	private void setNfc() {
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		if (!nfcAdapter.isEnabled()) {

			// NFC Setting UI
			AlertDialog.Builder ad = new AlertDialog.Builder(this);
			ad.setTitle("NFC 기능이 꺼져있습니다.");
			ad.setMessage("원할한 앱 사용을 위해 NFC 읽기쓰기/P2P 기능을 켜주세요");
			ad.setPositiveButton("OK", new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int whichButton) {
					int SDK_VERSION = android.os.Build.VERSION.SDK_INT;
					if (SDK_VERSION >= Build.VERSION_CODES.JELLY_BEAN)
						startActivity(new Intent(
								android.provider.Settings.ACTION_NFC_SETTINGS));
					else
						startActivity(new Intent(
								android.provider.Settings.ACTION_WIRELESS_SETTINGS));

				}
			});
			ad.create();
			ad.show();
		}
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
	}

	protected void onPostCreate(Bundle savedInstanceState) {
		super.onPostCreate(savedInstanceState);
		dtToggle.syncState();
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		if (dtToggle.onOptionsItemSelected(item)) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		super.onConfigurationChanged(newConfig);
		dtToggle.onConfigurationChanged(newConfig);
	}

	private class DrawerItemClickListener implements
			ListView.OnItemClickListener {

		@Override
		public void onItemClick(AdapterView<?> adapter, View view,
				int position, long id) {
			Intent intent = null;
			switch (position) {
			case 0:// 주위부스 확인
					// Wifi
				startScanWifi();
				break;
			case 1:
				intent = new Intent(ExhibitionListActivity.this,
						ExhibitionCheckInActivity.class);
				startActivity(intent);
				break;
			case 2:
				intent = new Intent(ExhibitionListActivity.this,
						ExhibitionRankActivity.class);
				startActivity(intent);
				break;
			case 3:
				intent = new Intent(ExhibitionListActivity.this,
						BoothFloorPlansActivity.class);
				startActivity(intent);
			}
			dlDrawer.closeDrawer(lvNavList);
		}
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
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
		
		if (indoorGPS.setScanList(mScanResult)) {
			ArrayList<Integer> alBoothIndex = indoorGPS.getBoothList();
			Intent intent = new Intent(ExhibitionListActivity.this,
					NearExhibitionListActivity.class);
			intent.putIntegerArrayListExtra("boothList", alBoothIndex);
			startActivity(intent);
			wifiProgressDialog.dismiss();
		} else {
			new AlertDialog.Builder(ExhibitionListActivity.this)
					.setTitle("Error").setMessage("전시장이 아닙니다.")
					.setPositiveButton("확인", new OnClickListener() {

						@Override
						public void onClick(DialogInterface dialog, int which) {
							// TODO Auto-generated method stub
							wifiProgressDialog.dismiss();
						}
					}).show();
		}

		unregisterReceiver(mReceiver);
		// if WIFIEnabled
		if (wifimanager.isWifiEnabled() && prevOffWifi)
			wifimanager.setWifiEnabled(false);

	}

	public void initWIFIScan() {
		wifiProgressDialog.show();
		// init WIFISCAN
		final IntentFilter filter = new IntentFilter(
				WifiManager.SCAN_RESULTS_AVAILABLE_ACTION);
		filter.addAction(WifiManager.NETWORK_STATE_CHANGED_ACTION);
		registerReceiver(mReceiver, filter);
		wifimanager.startScan();
	}

	// Detect Nfc
	@Override
	protected void onNewIntent(Intent intent) {
		super.onNewIntent(intent);
		Tag tag = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
		if (tag != null) {
			byte[] tagId = tag.getId();
			String str_tag = toHexString(tagId);
			int loop = alExhibition.size();
			for (int i = 0; i < loop; i++) {
				// get Exhibition that position is i
				Exhibition eh = alExhibition.get(i);
				for (String str : eh.getNfcTagId())
					if (str.equals(str_tag)) {
						// Ranking count increase
						PushWebServer pws = new PushWebServer();
						String androidId = ExhibitionDataManager.getInstance()
								.getAndroidId();
						String calendar = makeCalendarString();
						String pushMsg = String.format(
								"checkHitCount?index=%d&userID=%s&time=%s",
								eh.getIndex(), androidId, calendar);
						pws.setPushMsg(pushMsg);
						pws.start();
						// Intent
						Intent mIntent = new Intent(
								ExhibitionListActivity.this,
								ExhibitionActivity.class);
						// put Extra selectNum
						mIntent.putExtra("selectNum", i);
						startActivity(mIntent);
						break;
					}
			}
		}
	}

	private String makeCalendarString() {
		String str = null;
		Calendar cal = Calendar.getInstance();
		str = String.format("%d:%02d:%02d:%02d:%02d:%02d",
				cal.get(Calendar.YEAR), (cal.get(Calendar.MONTH) + 1),
				cal.get(Calendar.DATE), cal.get(Calendar.HOUR_OF_DAY),
				cal.get(Calendar.MINUTE), cal.get(Calendar.SECOND));
		return str;
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
}
