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
import com.googry.android.gradproj.data.ExhibitionDataManager;
import com.googry.android.gradproj.data.ExhibitionRank;

public class ExhibitionRankAdapter extends ArrayAdapter<ExhibitionRank> {
	private ArrayList<ExhibitionRank> alExRank;
	private Context mContext;
	private ArrayList<Exhibition> alExhibition;

	public ExhibitionRankAdapter(Context context, int resource,
			ArrayList<ExhibitionRank> objects) {
		super(context, resource, objects);
		alExRank = objects;
		mContext = context;
		alExhibition = ExhibitionDataManager.getInstance().getAlExhibition();
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null) {
			LayoutInflater vi = (LayoutInflater) mContext
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			v = vi.inflate(R.layout.row_exhibitionranklist, null);
		}
		ExhibitionRank ehRank = alExRank.get(position);
		Exhibition exhibition = alExhibition.get(alExRank.get(position)
				.getIndex() - 1);
		if (ehRank != null) {
			TextView tv_rank = (TextView) v.findViewById(R.id.tv_rank);
			TextView tv_productName = (TextView) v
					.findViewById(R.id.tv_productName);
			TextView tv_teamName = (TextView) v.findViewById(R.id.tv_teamName);
			TextView tv_rankCount = (TextView) v
					.findViewById(R.id.tv_rankCount);
			TextView tv_teamMember = (TextView) v
					.findViewById(R.id.tv_teamMember);
			if (tv_rank != null) {
				tv_rank.setText(ehRank.getRank() + "");
			}
			if (tv_productName != null) {
				tv_productName.setText(exhibition.getProductName());
			}
			if (tv_teamName != null) {
				tv_teamName.setText(mContext.getString(R.string.str_teamName)
						+ " : " + exhibition.getTeamName());
			}
			if (tv_rankCount != null) {
				tv_rankCount.setText((ehRank.getCount() - 1) + "번");
			}
			if (tv_teamMember != null) {
				tv_teamMember.setText(mContext.getString(R.string.str_member)
						+ " : " + exhibition.getMember());
			}
		}
		return v;
	}

}
