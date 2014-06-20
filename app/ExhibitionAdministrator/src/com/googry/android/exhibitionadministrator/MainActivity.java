package com.googry.android.exhibitionadministrator;

import java.util.ArrayList;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;

import com.googry.android.exhibitionadministrator.adapter.ExhibitionAdapter;
import com.googry.android.exhibitionadministrator.data.Exhibition;
import com.googry.android.exhibitionadministrator.data.ExhibitionDataManager;

public class MainActivity extends Activity {
	private ListView lv_exhibition_custom_list;
	private ArrayList<Exhibition> alExhibition;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);

		lv_exhibition_custom_list = (ListView) findViewById(R.id.lv_exhibition_custom_list);
		alExhibition = ExhibitionDataManager.getInstance().getAlExhibition();
		ExhibitionAdapter m_adapter = new ExhibitionAdapter(this,
				R.layout.row_exhibitionlist, alExhibition);

		lv_exhibition_custom_list.setAdapter(m_adapter);
		lv_exhibition_custom_list
				.setOnItemClickListener(new OnItemClickListener() {
					@Override
					public void onItemClick(AdapterView<?> parent, View view,
							int position, long id) {
						Intent intent = new Intent(MainActivity.this,
								ManagerActivity.class);
						intent.putExtra("exhibitionPosition",
								alExhibition.get(position).getIndex());
						startActivity(intent);
					}
				});
	}

}
