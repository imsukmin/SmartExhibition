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

public class ExhibitionAdapter extends ArrayAdapter<Exhibition> {
	private ArrayList<Exhibition> alExhibition;
	private Context mContext;

	public ExhibitionAdapter(Context context, int resource,
			ArrayList<Exhibition> objects) {
		super(context, resource, objects);
		alExhibition = objects;
		mContext = context;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null) {
			LayoutInflater vi = (LayoutInflater) mContext
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			v = vi.inflate(R.layout.row_exhibitionlist, null);
		}
		Exhibition eh = alExhibition.get(position);
		if (eh != null) {
			TextView tv_productName = (TextView) v
					.findViewById(R.id.tv_productName);
			TextView tv_teamName = (TextView) v.findViewById(R.id.tv_teamName);
			TextView tv_professor = (TextView) v
					.findViewById(R.id.tv_professor);
			TextView tv_teamMember = (TextView) v
					.findViewById(R.id.tv_teamMember);
			if (tv_productName != null) {
				tv_productName.setText(eh.getProductName());
			}
			if (tv_teamName != null) {
				tv_teamName.setText(mContext.getString(R.string.str_teamName)+" : "+ eh.getTeamName());
				
			}
			if (tv_professor != null) {
				tv_professor.setText(mContext.getString(R.string.str_professor)+" : "+eh.getProfessor());
			}
			if (tv_teamMember != null) {
				tv_teamMember.setText(mContext.getString(R.string.str_member)+" : "+eh.getMember());
			}
		}
		return v;
	}

}
