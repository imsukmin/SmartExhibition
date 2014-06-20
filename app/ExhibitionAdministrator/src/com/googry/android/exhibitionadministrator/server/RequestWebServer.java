package com.googry.android.exhibitionadministrator.server;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.util.ArrayList;

import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;

import com.googry.android.exhibitionadministrator.data.ExhibitionDataManager;

public class RequestWebServer extends Thread {
	private ArrayList<String> strList;

	public interface GetServerJsonMessage {
		void onGetServerMsg(String requestCode, String[][] parserString);
	}

	GetServerJsonMessage onGetServerJsonMessageListener = null;

	public void setOnGetServerJsonMessageListener(
			GetServerJsonMessage getServerJsonMessage) {
		onGetServerJsonMessageListener = getServerJsonMessage;
	}

	public void setMsgs(String... strs) {
		for (String str : strs) {
			strList.add(str);
		}
	}

	public RequestWebServer() {
		strList = new ArrayList<String>();
	}

	@Override
	public void run() {
		// TODO Auto-generated method stub
		for (String str : strList) {
			SendByHttp(str);
		}
	}

	private synchronized void SendByHttp(String msg) {
		String URL = "http://54.178.156.102:43125/" + msg;

		DefaultHttpClient client = new DefaultHttpClient();
		try {
			HttpGet get = new HttpGet(URL);

			HttpParams params = client.getParams();
			HttpConnectionParams.setConnectionTimeout(params, 3000);
			HttpConnectionParams.setSoTimeout(params, 3000);

			HttpResponse response = client.execute(get);

			BufferedReader bufreader = new BufferedReader(
					new InputStreamReader(response.getEntity().getContent(),
							"utf-8"));

			String line = null;
			String result = "";

			while ((line = bufreader.readLine()) != null) {
				result += line;
			}
			if (onGetServerJsonMessageListener != null) {
				String[][] jsonString = null;
				if (msg.equals(ExhibitionDataManager.BOOTHINFO)) {
					jsonString = JsonParser.jsonBoothListParser(result);
				} else if (msg.equals(ExhibitionDataManager.GETAP)) {
					jsonString = JsonParser.jsonAPListParser(result);
				}
				onGetServerJsonMessageListener.onGetServerMsg(msg, jsonString);
			}
		} catch (Exception e) {
			e.printStackTrace();
			client.getConnectionManager().shutdown();
		}

	}
}
