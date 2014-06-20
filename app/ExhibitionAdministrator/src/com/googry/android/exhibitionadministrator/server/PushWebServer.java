package com.googry.android.exhibitionadministrator.server;

import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;

public class PushWebServer extends Thread {
	private String str_pushMsg;

	public void setPushMsg(String msg) {
		this.str_pushMsg = msg;
	}

	@Override
	public void run() {
		// TODO Auto-generated method stub
		SendByHttp(str_pushMsg);
	}

	private synchronized void SendByHttp(String msg) {
		String URL = "http://54.178.156.102:43125/" + msg;

		DefaultHttpClient client = new DefaultHttpClient();
		try {
			HttpGet get = new HttpGet(URL);

			HttpParams params = client.getParams();
			HttpConnectionParams.setConnectionTimeout(params, 3000);
			HttpConnectionParams.setSoTimeout(params, 3000);

			client.execute(get);
		} catch (Exception e) {
			e.printStackTrace();
			client.getConnectionManager().shutdown();
		}

	}
}
