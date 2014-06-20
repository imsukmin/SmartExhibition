package com.googry.android.gradproj;

import java.util.ArrayList;

import android.app.Activity;
import android.app.PendingIntent;
import android.content.Intent;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.widget.TextView;

import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.server.PushWebServer;

public class ExhibitionActivity extends Activity {
	private ArrayList<Exhibition> ehList;
	private TextView productName;
	private TextView professor;
	private TextView member;
	private TextView outline;
	private TextView target;
	private TextView homepage;
	private TextView summary;

	// NfcAdapter variable
	private NfcAdapter nfcAdapter;
	private PendingIntent pendingIntent;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_exhibition);
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		Intent intent = new Intent(this, getClass())
				.addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
		pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);
		getTextViewId();
		setText2TextView();
	}

	private void getTextViewId() {
		productName = (TextView) findViewById(R.id.tv_productName);
		professor = (TextView) findViewById(R.id.tv_professor);
		member = (TextView) findViewById(R.id.tv_member);
		outline = (TextView) findViewById(R.id.tv_outline);
		target = (TextView) findViewById(R.id.tv_target);
		homepage = (TextView) findViewById(R.id.tv_homepage);
		summary = (TextView) findViewById(R.id.tv_summary);
	}

	private void setText2TextView() {
		ehList = ExhibitionDataManager.getInstance().getAlExhibition();
		Intent intent = getIntent();
		int selectNum = intent.getIntExtra("selectNum", -1);
		Exhibition exhibition = ehList.get(selectNum);
		this.setTitle(exhibition.getTeamName());
		productName.setText(exhibition.getProductName());
		professor.setText(exhibition.getProfessor());
		member.setText(exhibition.getMember());
		outline.setText(exhibition.getOutline());
		target.setText(exhibition.getTarget());
		homepage.setText(exhibition.getHomepage());
		summary.setText(exhibition.getSummary());
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
