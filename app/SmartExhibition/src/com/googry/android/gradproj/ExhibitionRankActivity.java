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

import com.googry.android.gradproj.adapter.ExhibitionRankAdapter;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.data.ExhibitionRank;
import com.googry.android.gradproj.server.RequestWebServer;
import com.googry.android.gradproj.server.RequestWebServer.GetServerJsonMessage;

public class ExhibitionRankActivity extends Activity {
	private ArrayList<ExhibitionRank> alRank;
	private ExhibitionRankAdapter ehRankAdapter;
	private int coRankingCnt;

	private Handler h;

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;
	
	// ProgressDialog
	private ProgressDialog wifiProgressDialog;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_exhibitionrank);
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
		this.setTitle(getString(R.string.str_seeBoothRanking));
		coRankingCnt = 0;
		alRank = new ArrayList<ExhibitionRank>();
		
		wifiProgressDialog = new ProgressDialog(ExhibitionRankActivity.this);
		wifiProgressDialog.setTitle("로딩중...");
		wifiProgressDialog.setMessage("서버에서 랭킹을 불러오는 중");
		wifiProgressDialog.show();
		
		h = new Handler();
		RequestWebServer rws = new RequestWebServer();
		rws.setMsgs(ExhibitionDataManager.SHOWRANKING);
		rws.start();
		rws.setOnGetServerJsonMessageListener(new GetServerJsonMessage() {

			@Override
			public void onGetServerMsg(String requestCode,
					String[][] parserString) {
				// TODO Auto-generated method stub
				if (requestCode.equals(ExhibitionDataManager.SHOWRANKING)) {
					for (int i = 0; i < parserString.length; i++) {
						ExhibitionRank exRank = new ExhibitionRank(Integer
								.parseInt(parserString[i][0]), Integer
								.parseInt(parserString[i][1]));
						if (i != 0) {
							if (exRank.getCount() == alRank.get(i - 1)
									.getCount()) {
								coRankingCnt++;
							} else {
								coRankingCnt = 0;
							}
						}
						exRank.setRank(i + 1 - coRankingCnt);
						alRank.add(exRank);
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
		ehRankAdapter = new ExhibitionRankAdapter(getBaseContext(),
				R.layout.row_exhibitionranklist, alRank);
		ListView lv_rank = (ListView) findViewById(R.id.lv_exhibitionrank);
		lv_rank.setAdapter(ehRankAdapter);
		lv_rank.setOnItemClickListener(new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Intent intent = new Intent(ExhibitionRankActivity.this,
						ExhibitionActivity.class);
				intent.putExtra("selectNum",
						alRank.get(position).getIndex() - 1);
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
