package com.googry.android.exhibitionadministrator.adapter;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.googry.android.exhibitionadministrator.R;
import com.googry.android.exhibitionadministrator.data.Exhibition;
import com.googry.android.exhibitionadministrator.data.WifiApMacAddress;

public class WifiApMacAddressAdapter extends ArrayAdapter<WifiApMacAddress> {
	private ArrayList<WifiApMacAddress> alWAMA;
	private Context mContext;

	public WifiApMacAddressAdapter(Context context, int resource,
			ArrayList<WifiApMacAddress> objects) {
		super(context, resource, objects);
		alWAMA = objects;
		mContext = context;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null) {
			LayoutInflater vi = (LayoutInflater) mContext
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			v = vi.inflate(R.layout.row_wifiapmacaddress, null);
		}
		WifiApMacAddress wama = alWAMA.get(position);
		if (wama != null) {
			TextView tv_mac_ssid = (TextView) v.findViewById(R.id.tv_mac_ssid);
			TextView tv_mac_bssid = (TextView) v
					.findViewById(R.id.tv_mac_bssid);
			TextView tv_mac_apLevel = (TextView) v
					.findViewById(R.id.tv_mac_apLevel);
			if (tv_mac_ssid != null) {
				tv_mac_ssid.setText("SSID : "
						+ wama.getSSID());
			}
			if (tv_mac_bssid != null) {
				tv_mac_bssid.setText("BSSID : "
						+ wama.getBSSID());
			}
			if (tv_mac_apLevel != null) {
				tv_mac_apLevel.setText("APLevel : "
						+ wama.getApLevel());
			}
		}
		return v;
	}
}
