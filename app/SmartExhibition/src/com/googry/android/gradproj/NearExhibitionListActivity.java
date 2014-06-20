package com.googry.android.gradproj;

import java.util.ArrayList;

import android.app.Activity;
import android.app.PendingIntent;
import android.content.Intent;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;

import com.googry.android.gradproj.adapter.ExhibitionAdapter;
import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionDataManager;

public class NearExhibitionListActivity extends Activity {

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_nearexhibitionlist);
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
		this.setTitle(getString(R.string.str_nearBoothCurrentState));
		Intent intent2 = getIntent();
		final ArrayList<Integer> boothList = intent2
				.getIntegerArrayListExtra("boothList");
		ArrayList<Exhibition> exList = ExhibitionDataManager.getInstance()
				.getAlExhibition();
		ArrayList<Exhibition> mExList = new ArrayList<Exhibition>();
		for (int i = 0; i < boothList.size(); i++) {
			mExList.add(exList.get(boothList.get(i)));
		}
		ListView lv_exhibition_custom_list = (ListView) findViewById(R.id.lv_near_exhibition_custom_list);
		ExhibitionAdapter m_adapter = new ExhibitionAdapter(this,
				R.layout.row_exhibitionlist, mExList);

		lv_exhibition_custom_list.setAdapter(m_adapter);
		lv_exhibition_custom_list
				.setOnItemClickListener(new OnItemClickListener() {
					@Override
					public void onItemClick(AdapterView<?> parent, View view,
							int position, long id) {
						Intent intent = new Intent(
								NearExhibitionListActivity.this,
								ExhibitionActivity.class);
						intent.putExtra("selectNum", boothList.get(position));
						startActivity(intent);
						finish();
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
