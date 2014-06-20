package com.googry.android.gradproj.data;

public class Exhibition {
	private int index;
	private String teamName;
	private String productName;
	private String professor;
	private String member;
	private String outline;
	private String target;
	private String homepage;
	private String brochure;
	private String nfcTagId[];
	private String apLevel;
	private String summary;

	// "index", "teamName", "productName",
	// "professor", "member", "outline", "target", "homepage",
	// "broshure", "nfcTagId", "apLevel", "summary" };
	public Exhibition(int index, String teamName, String productName,
			String professor, String member, String outline, String target,
			String homepage, String brochure, String nfcTagId[], String apLevel,
			String summary) {
		this.index = index;
		this.teamName = teamName;
		this.productName = productName;
		this.professor = professor;
		this.member = member;
		this.outline = outline;
		this.target = target;
		this.homepage = homepage;
		this.brochure = brochure;
		this.nfcTagId = nfcTagId;
		this.apLevel = apLevel;
		this.summary = summary;
	}

	public int getIndex() {
		return index;
	}

	public String getTeamName() {
		return teamName;
	}

	public String getProductName() {
		return productName;
	}

	public String getProfessor() {
		return professor;
	}

	public String getMember() {
		return member;
	}

	public String getOutline() {
		return outline;
	}

	public String getTarget() {
		return target;
	}

	public String getHomepage() {
		return homepage;
	}

	public String getBrochure() {
		return brochure;
	}

	public String[] getNfcTagId() {
		return nfcTagId;
	}

	public String getApLevel() {
		return apLevel;
	}

	public String getSummary() {
		return summary;
	}

}
