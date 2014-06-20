package com.googry.android.gradproj.data;

public class ExhibitionRank {
	private int index;
	private int count;
	private int rank;

	public int getRank() {
		return rank;
	}

	public void setRank(int rank) {
		this.rank = rank;
	}

	public ExhibitionRank(int index, int count) {
		this.index = index;
		this.count = count;
	}

	public int getIndex() {
		return index;
	}

	public int getCount() {
		return count;
	}
}
