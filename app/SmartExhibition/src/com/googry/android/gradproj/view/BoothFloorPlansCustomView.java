package com.googry.android.gradproj.view;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Point;
import android.util.AttributeSet;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;

public class BoothFloorPlansCustomView extends View {

	private int viewWidth, viewHeight;
	private Point clientPoint;
	private int ballRadius;

	public BoothFloorPlansCustomView(Context context, AttributeSet attrs) {
		super(context, attrs);
		clientPoint = new Point(-ballRadius * 2, -ballRadius * 2);
	}

	@Override
	protected void onDraw(Canvas canvas) {
		if (viewWidth != getWidth() || viewHeight != getHeight()) {
			initData();
		}
		Paint paint = new Paint();
		paint.setColor(Color.RED);
		canvas.drawCircle(clientPoint.x, clientPoint.y, ballRadius, paint);
	}

	@Override
	public boolean onTouchEvent(MotionEvent event) {
		// TODO Auto-generated method stub
		int action = event.getAction();
		if (action == MotionEvent.ACTION_DOWN) {
			Log.i("googrybug", "(" + (int)event.getX() + "," + (int)event.getY()+")");
		}
		return super.onTouchEvent(event);
	}

	private void initData() {
		viewWidth = getWidth();
		viewHeight = getHeight();
		ballRadius = viewHeight / 15;
	}

	public void invalidatePoint(Point point) {
		clientPoint = point;
		this.invalidate();
	}

}
