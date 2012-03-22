import processing.core.*; 
import processing.xml.*; 

import java.applet.*; 
import java.awt.*; 
import java.awt.image.*; 
import java.awt.event.*; 
import java.io.*; 
import java.net.*; 
import java.text.*; 
import java.util.*; 
import java.util.zip.*; 
import java.util.regex.*; 

public class round_09c_focus_handling extends PApplet {

/*
This book is here to help you get your job done. In general, you may use the 
code in this book in your programs and documentation. You do not need to contact 
us for permission unless you\ufffdre reproducing a significant portion of the code. 
For example, writing a program that uses several chunks of code from this book 
does not require permission. Selling or distributing a CD-ROM of examples from 
O\ufffdReilly books does require permission. Answering a question by citing this book 
and quoting example code does not require permission. Incorporating a significant
amount of example code from this book into your product\ufffds documentation does 
require permission.

We appreciate, but do not require, attribution. An attribution usually includes
the title, author, publisher, and ISBN. For example: \ufffdVisualizing Data, First 
Edition by Ben Fry. Copyright 2008 Ben Fry, 9780596514556.\ufffd

If you feel your use of code examples falls outside fair use or the permission
given above, feel free to contact us at permissions@oreilly.com.
*/

int backgroundColor  = 0xff333333;  // dark background color
int dormantColor     = 0xff999966;  // initial color of the map
int highlightColor   = 0xffCBCBCB;  // color for selected points
int unhighlightColor = 0xff66664C;  // color for points that are not selected
int waitingColor     = 0xffCBCBCB;  // "please type a zip code" message
int badColor         = 0xffFFFF66;  // text color when nothing found

ColorIntegrator faders[];

// border of where the map should be drawn on screen   
float mapX1, mapY1;
float mapX2, mapY2;

// column numbers in the data file
static final int CODE = 0;
static final int X = 1;
static final int Y = 2;
static final int NAME = 3;

int totalCount;  // total number of places
Place[] places;
int placeCount;  // number of places loaded

// min/max boundary of all points
float minX, maxX;
float minY, maxY;
  
// typing and selection  
PFont font;
String typedString = "";
char typedChars[] = new char[5];
int typedCount;
int typedPartials[] = new int[6];

float messageX, messageY;

int foundCount;
Place chosen;
  
// smart updates
int notUpdatedCount = 0;
  
// zoom
boolean zoomEnabled = false;
Integrator zoomDepth = new Integrator();

Integrator zoomX1;
Integrator zoomY1;
Integrator zoomX2;
Integrator zoomY2;

float targetX1[] = new float[6];
float targetY1[] = new float[6];
float targetX2[] = new float[6];
float targetY2[] = new float[6];

// boundary of currently valid points at this typedCount
float boundsX1, boundsY1;
float boundsX2, boundsY2;  
  

public void setup() {
  size(720, 453, P3D);
    
  mapX1 = 30;
  mapX2 = width - mapX1;
  mapY1 = 20;
  mapY2 = height - mapY1;
   
  font = loadFont("ScalaSans-Regular-14.vlw");
  textFont(font);
  textMode(SCREEN);
    
  messageX = 40;
  messageY = height - 40;

  faders = new ColorIntegrator[6];
    
  // When nothing is typed, all points are shown with a color called
  // "dormant," which is brighter than when not highlighted, but 
  // not as bright as the highlight color for a selection.
  faders[0] = new ColorIntegrator(unhighlightColor, dormantColor);
  faders[0].attraction = 0.5f;
  faders[0].target(1);

  for (int i = 1; i < 6; i++) {
    faders[i] = new ColorIntegrator(unhighlightColor, highlightColor);
    faders[i].attraction = 0.5f;
    faders[i].target(1);
  }
    
  readData();
    
  zoomX1 = new Integrator(minX);
  zoomY1 = new Integrator(minY);
  zoomX2 = new Integrator(maxX);
  zoomY2 = new Integrator(maxY);
    
  targetX1[0] = minX;
  targetX2[0] = maxX;
  targetY1[0] = minY;
  targetY2[0] = maxY;
    
  rectMode(CENTER);
  ellipseMode(CENTER);
  frameRate(15);
}
    
  
  
public void readData() {
  new Slurper();
  noLoop();  // done loading, can stop updating
}
  
  
public void parseInfo(String line) {
  String infoString = line.substring(2);  // remove the #
  String[] infoPieces = split(infoString, ',');
  totalCount = PApplet.parseInt(infoPieces[0]);   
  minX = PApplet.parseFloat(infoPieces[1]);
  maxX = PApplet.parseFloat(infoPieces[2]);
  minY = PApplet.parseFloat(infoPieces[3]);
  maxY = PApplet.parseFloat(infoPieces[4]);
}
  
  
public Place parsePlace(String line) {
  String pieces[] = split(line, TAB);

  int zip = PApplet.parseInt(pieces[CODE]);
  float x = PApplet.parseFloat(pieces[X]);
  float y = PApplet.parseFloat(pieces[Y]);
  String name = pieces[NAME];

  return new Place(zip, name, x, y);
}
  

// change message from 'click inside the window'
public void focusGained() {
  redraw();
}

// change message to 'click inside the window'
public void focusLost() {
  redraw();
}

// this method is empty in p5
public void mouseEntered() {
  requestFocus();
}


public void draw() {
  background(backgroundColor);

  updateAnimation();

  for (int i = 0; i < placeCount; i++) {
    places[i].draw();
  }

  if (typedCount == 0) {
    fill(waitingColor);
    textAlign(LEFT);
    String message = "zipdecode by ben fry";
    // if all places are loaded
    if (placeCount == totalCount) {
      if (focused) {
	message = "type the digits of a zip code";
      } else {
	message = "click the map image to begin";
      }
    }
    text(message, messageX, messageY);
      
  } else {
    if (foundCount > 0) {
      if (!zoomEnabled && (typedCount == 4)) {
	// re-draw the chosen ones, because they're often occluded
	// by the non-selected points
	for (int i = 0; i < placeCount; i++) {
	  if (places[i].matchDepth == typedCount) {
	    places[i].draw();
	  }
	}
      }

      if (chosen != null) {
	chosen.drawChosen();
      }
        
      fill(highlightColor);
      textAlign(LEFT);
      text(typedString, messageX, messageY);
        
    } else {
      fill(badColor);
      text(typedString, messageX, messageY);
    }
  }

  // draw "zoom" text toggle
  textAlign(RIGHT);
  fill(zoomEnabled ? highlightColor : unhighlightColor);
  text("zoom", width - 40, height - 40);
  textAlign(LEFT);
}
  
  
public void updateAnimation() {
  boolean updated = false;
    
  for (int i = 0; i < 6; i++) {
    updated |= faders[i].update();
  }
    
  if (foundCount > 0) {
    zoomDepth.target(typedCount);
  } else {
    zoomDepth.target(typedCount-1);
  }
  updated |= zoomDepth.update();

  updated |= zoomX1.update();
  updated |= zoomY1.update();
  updated |= zoomX2.update();
  updated |= zoomY2.update();

  // if the data is loaded, can optionally call noLoop() to save cpu
  if (placeCount == totalCount) {  // if fully loaded
    if (!updated) {
      notUpdatedCount++;
      // after 20 frames of no updates, shut off the loop
      if (notUpdatedCount > 20) {
	noLoop();
	notUpdatedCount = 0;
      }
    } else {
      notUpdatedCount = 0;
    }
  }
}

  
public float TX(float x) {
  if (zoomEnabled) {
    return map(x, zoomX1.value, zoomX2.value, mapX1, mapX2);

  } else {
    return map(x, minX, maxX, mapX1, mapX2);
  }
}


public float TY(float y) {
  if (zoomEnabled) {
    return map(y, zoomY1.value, zoomY2.value, mapY2, mapY1);

  } else {
    return map(y, minY, maxY, mapY2, mapY1);
  }
}


public void mousePressed() {
  if ((mouseX > width-100) && (mouseY > height - 50)) {
    zoomEnabled = !zoomEnabled;
    redraw();
  }
}


public void keyPressed() {
  if ((key == BACKSPACE) || (key == DELETE)) {
    if (typedCount > 0) {
      typedCount--;
    }
    updateTyped();

  } else if ((key >= '0') && (key <= '9')) {
    if (typedCount != 5) {  // only 5 digits
      if (foundCount > 0) {  // don't allow to keep typing bad
	typedChars[typedCount++] = key;
      }
    }
  }
  updateTyped();
}


public void updateTyped() {
  typedString = new String(typedChars, 0, typedCount);

  // Un-highlight areas already typed past
  for (int i = 0; i < typedCount; i++) faders[i].target(0);
  // Highlight potential dots not yet selected by keys
  for (int i = typedCount; i < 6; i++) faders[i].target(1);

  typedPartials[typedCount] = PApplet.parseInt(typedString);
  for (int j = typedCount-1; j > 0; --j) {
    typedPartials[j] = typedPartials[j + 1] / 10;
  }

  foundCount = 0;
  chosen = null;
    
  boundsX1 = maxX;
  boundsY1 = maxY;
  boundsX2 = minX;
  boundsY2 = minY;

  for (int i = 0; i < placeCount; i++) {
    // update boundaries of selection
    // and identify whether a particular place is chosen
    places[i].check();
  }
  calcZoom();

  loop(); // re-enable updates
}

  
public void calcZoom() {
  if (foundCount != 0) {
    // given a set of min/max coords, expand in one direction so that the 
    // selected area includes the range with the proper aspect ratio

    float spanX = (boundsX2 - boundsX1);
    float spanY = (boundsY2 - boundsY1);
      
    float midX = (boundsX1 + boundsX2) / 2;
    float midY = (boundsY1 + boundsY2) / 2;
      
    if ((spanX != 0) && (spanY != 0)) {
      float screenAspect = width / PApplet.parseFloat(height);
      float spanAspect = spanX / spanY;
        
      if (spanAspect > screenAspect) {
	spanY = (spanX / width) * height;  // wide
          
      } else {
	spanX = (spanY / height) * width;  // tall          
      }
    } else {  // if span is zero
      // use the span from one level previous
      spanX = targetX2[typedCount-1] - targetX1[typedCount-1];
      spanY = targetY2[typedCount-1] - targetY1[typedCount-1];
    }
    targetX1[typedCount] = midX - spanX/2;
    targetX2[typedCount] = midX + spanX/2;
    targetY1[typedCount] = midY - spanY/2;
    targetY2[typedCount] = midY + spanY/2;

  } else if (typedCount != 0) {
    // nothing found at this level, so set the zoom identical to the previous
    targetX1[typedCount] = targetX1[typedCount-1];
    targetY1[typedCount] = targetY1[typedCount-1];
    targetX2[typedCount] = targetX2[typedCount-1];
    targetY2[typedCount] = targetY2[typedCount-1];
  }

  zoomX1.target(targetX1[typedCount]);
  zoomY1.target(targetY1[typedCount]);
  zoomX2.target(targetX2[typedCount]);
  zoomY2.target(targetY2[typedCount]);

  if (!zoomEnabled) {
    zoomX1.set(zoomX1.target);
    zoomY1.set(zoomY1.target);
    zoomX2.set(zoomX2.target);
    zoomY2.set(zoomY2.target);
  }
}
// Code from Visualizing Data, First Edition, Copyright 2008 Ben Fry.


class Place {
  int code;
  String name;
  float x;
  float y;
		    
  int partial[];
  int matchDepth;


  public Place(int code, String name, float lon, float lat) {
    this.code = code;
    this.name = name;
    this.x = lon;
    this.y = lat;

    partial = new int[6];
    partial[5] = code;
    partial[4] = partial[5] / 10;
    partial[3] = partial[4] / 10;
    partial[2] = partial[3] / 10;
    partial[1] = partial[2] / 10;
  }


  public void check() {
    // default to zero levels of depth that match
    matchDepth = 0;

    if (typedCount != 0) {
      // Start from the greatest depth, and work backwards to see how many 
      // items match. Want to figure out the maximum match, so better to 
      // begin from the end. 
      // The multiple levels of matching are important because more than one
      // depth level might be fading at a time.
      for (int j = typedCount; j > 0; --j) {
	if (typedPartials[j] == partial[j]) {
	  matchDepth = j;
	  break;  // since starting at end, can stop now
	}
      }
    }

    //if (partial[typedCount] == partialCode) {
    if (matchDepth == typedCount) {
      foundCount++;
      if (typedCount == 5) {
	chosen = this;
      }

      if (x < boundsX1) boundsX1 = x;
      if (y < boundsY1) boundsY1 = y;
      if (x > boundsX2) boundsX2 = x;
      if (y > boundsY2) boundsY2 = y;        
    }
  }

  public void draw() {
    float xx = TX(x);
    float yy = TY(y);

    if ((xx < 0) || (yy < 0) || (xx >= width) || (yy >= height)) return;

    if ((zoomDepth.value < 2.8f) || !zoomEnabled) {  // show simple dots
      //pixels[((int) yy) * width + ((int) xx)] = faders[matchDepth].cvalue;
      set((int)xx, (int)yy, faders[matchDepth].colorValue);

    } else {  // show slightly more complicated dots
      noStroke();

      fill(faders[matchDepth].colorValue);
      //rect(TX(nlon), TY(nlat), depther.value-1, depther.value-1);

      if (matchDepth == typedCount) {
	if (typedCount == 4) {  // on the fourth digit, show nums for the 5th
	  text(code % 10, TX(x), TY(y));
	} else {  // show a larger box for selections
	  rect(xx, yy, zoomDepth.value, zoomDepth.value);
	}
      } else {  // show a slightly smaller box for unselected
	rect(xx, yy, zoomDepth.value-1, zoomDepth.value-1);
      }
    }
  }


  public void drawChosen() {
    noStroke();
    fill(faders[matchDepth].colorValue);
    // the chosen point has to be a little larger when zooming
    int size = zoomEnabled ? 6 : 4;
    rect(TX(x), TY(y), size, size);

    // calculate position to draw the text, slightly offset from the main point
    float textX = TX(x);
    float textY = TY(y) - size - 4;

    // don't go off the top.. (e.g. 59544)
    if (textY < 20) {
      textY = TY(y) + 20;
    }

    // don't run off the bottom.. (e.g. 33242)
    if (textY > height - 5) {
      textY = TY(y) - 20;
    }

    String location = name + "  " + nf(code, 5);

    if (zoomEnabled) {
      textAlign(CENTER);
      text(location, textX, textY);

    } else {
      float wide = textWidth(location);

      if (textX > width/3) {
	textX -= wide + 8;
      } else {
	textX += 8;
      }

      textAlign(LEFT);
      fill(highlightColor);
      text(location, textX, textY);
    }
  }
}
// Code from Visualizing Data, First Edition, Copyright 2008 Ben Fry.


class Slurper implements Runnable {

  Slurper() {
    Thread thread = new Thread(this);
    thread.start();
  }

  public void run() {
    try {
      InputStream input = openStream("zips.gz");
      BufferedReader reader = createReader(input);
      
      // first get the info line
      String line = reader.readLine();
      parseInfo(line);

      places = new Place[totalCount];

      // parse each of the rest of the lines
      while ((line = reader.readLine()) != null) {
        places[placeCount] = parsePlace(line);
        placeCount++;
      }
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
}

  static public void main(String args[]) {
    PApplet.main(new String[] { "--bgcolor=#C0C0C0", "round_09c_focus_handling" });
  }
}
