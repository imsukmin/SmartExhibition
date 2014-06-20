package com.googry.android.gradproj;

import java.util.ArrayList;

import android.app.Activity;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Intent;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;

import com.googry.android.gradproj.adapter.ExhibitionCheckInAdapter;
import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionCheckIn;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.server.RequestWebServer;
import com.googry.android.gradproj.server.RequestWebServer.GetServerJsonMessage;

public class ExhibitionCheckInActivity extends Activity {
	private ArrayList<ExhibitionCheckIn> alCheckIn;
	private ExhibitionCheckInAdapter ehCheckInAdapter;
	private ArrayList<Exhibition> alExhibition;

	private Handler h;

	private final String[] str_CalendarTag = { "년", "월", "일", "시", "분", "초" };

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;

	// ProgressDialog
	private ProgressDialog wifiProgressDialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_exhibitioncheckin);
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
		this.setTitle(getString(R.string.str_checkInBoothChecking));
		alCheckIn = new ArrayList<ExhibitionCheckIn>();

		wifiProgressDialog = new ProgressDialog(ExhibitionCheckInActivity.this);
		wifiProgressDialog.setTitle("로딩중...");
		wifiProgressDialog.setMessage("서버에서 랭킹을 불러오는 중");
		wifiProgressDialog.show();

		h = new Handler();
		String setMsg = String.format("checkinINFO?userID="
				+ ExhibitionDataManager.getInstance().getAndroidId());
		RequestWebServer rws = new RequestWebServer();
		rws.setMsgs(setMsg);
		rws.start();
		rws.setOnGetServerJsonMessageListener(new GetServerJsonMessage() {

			@Override
			public void onGetServerMsg(String requestCode,
					String[][] parserString) {
				// TODO Auto-generated method stub
				if (requestCode.contains(ExhibitionDataManager.CHECKININFO)) {
					for (int i = 0; i < parserString.length; i++) {
						String str_Calendar = "";
						String str_cals[] = parserString[i][2].split(":");
						for (int j = 0; j < str_cals.length; j++) {
							str_Calendar += str_cals[j] + str_CalendarTag[j];
						}
						ExhibitionCheckIn exCheckIn = new ExhibitionCheckIn(
								Integer.parseInt(parserString[i][0]),
								parserString[i][1], str_Calendar);
						alCheckIn.add(exCheckIn);
					}
					h.postDelayed(runnalbe, 0);

				}
			}
		});
	}

	Runnable runnalbe = new Runnable() {

		@Override
		public void run() {
			setCustomListView();
			wifiProgressDialog.dismiss();
		}
	};

	private void setCustomListView() {
		ehCheckInAdapter = new ExhibitionCheckInAdapter(getBaseContext(),
				R.layout.row_exhibitionranklist, alCheckIn);
		ListView lv_rank = (ListView) findViewById(R.id.lv_exhibitionCheckIn);
		lv_rank.setAdapter(ehCheckInAdapter);
		lv_rank.setOnItemClickListener(new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent = new Intent(ExhibitionCheckInActivity.this,
						ExhibitionActivity.class);
				intent.putExtra("selectNum",
						alCheckIn.get(position).getIndex() - 1);
				startActivity(intent);
			}
		});
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
		}
	}
}
