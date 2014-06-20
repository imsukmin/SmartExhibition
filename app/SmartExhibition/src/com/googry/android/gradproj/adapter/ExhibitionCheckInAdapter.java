package com.googry.android.gradproj.adapter;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.googry.android.gradproj.R;
import com.googry.android.gradproj.data.Exhibition;
import com.googry.android.gradproj.data.ExhibitionCheckIn;
import com.googry.android.gradproj.data.ExhibitionDataManager;

public class ExhibitionCheckInAdapter extends ArrayAdapter<ExhibitionCheckIn> {
	private ArrayList<ExhibitionCheckIn> alExCheckIn;
	private Context mContext;
	private ArrayList<Exhibition> alExhibition;

	public ExhibitionCheckInAdapter(Context context, int resource,
			ArrayList<ExhibitionCheckIn> objects) {
		super(context, resource, objects);
		alExCheckIn = objects;
		mContext = context;
		alExhibition = ExhibitionDataManager.getInstance().getAlExhibition();
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null) {
			LayoutInflater vi = (LayoutInflater) mContext
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			v = vi.inflate(R.layout.row_exhibitioncheckinlist, null);
		}
		ExhibitionCheckIn ehCheckIn = alExCheckIn.get(position);
		Exhibition exhibition = alExhibition.get(alExCheckIn.get(position)
				.getIndex() - 1);
		if (ehCheckIn != null) {
			TextView tv_productName = (TextView) v
					.findViewById(R.id.tv_productName);
			TextView tv_teamName = (TextView) v.findViewById(R.id.tv_teamName);
			TextView tv_teamMember = (TextView) v
					.findViewById(R.id.tv_teamMember);
			TextView tv_checkInTime = (TextView) v
					.findViewById(R.id.tv_checkInTime);
			if (tv_productName != null) {
				tv_productName.setText(exhibition.getProductName());
			}
			if (tv_teamName != null) {
				tv_teamName.setText(mContext.getString(R.string.str_teamName)
						+ " : " + exhibition.getTeamName());
			}
			if (tv_teamMember != null) {
				tv_teamMember.setText(mContext.getString(R.string.str_member)
						+ " : " + exhibition.getMember());
			}
			if (tv_checkInTime != null) {
				tv_checkInTime.setText(ehCheckIn.getCheckIn());
			}
		}
		return v;
	}
}
