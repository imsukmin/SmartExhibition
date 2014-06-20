package com.googry.android.exhibitionadministrator;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class PasswordActivity extends Activity implements OnClickListener {
	private TextView tv_question;
	private EditText ed_answerSheet;
	private Button btn_cancel, btn_ok;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_password);
		setId();
		setListener();
		tv_question.setText("Please enter a Password");

	}

	private void setId() {
		tv_question = (TextView) findViewById(R.id.tv_question);
		ed_answerSheet = (EditText) findViewById(R.id.ed_answerSheet);
		btn_cancel = (Button) findViewById(R.id.btn_cancel);
		btn_ok = (Button) findViewById(R.id.btn_ok);
	}

	private void setListener() {
		btn_cancel.setOnClickListener(this);
		btn_ok.setOnClickListener(this);
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.btn_cancel:
			finish();
			break;
		case R.id.btn_ok:
			String answer = ed_answerSheet.getText().toString();
			if (answer.equals("P@ssw0rd7r")) {
				Intent intent = new Intent(PasswordActivity.this,
						MainActivity.class);
				startActivity(intent);
			}
			finish();
		}

	}

}
