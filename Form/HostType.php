PImage img1, img2, img3, img4, img5;
String estado;
void setup (){
size(400,400);
img1 = loadImage("Recurso 1.png");
img2 = loadImage("Recurso 2.png");
img3 = loadImage("Recurso 3.png");
img4 = loadImage("Recurso 4.png");
img5 = loadImage("Recurso 5.png");
estado = "imagen1" ;
keyPressed = false ;
}

void draw(){
image(img1,0,0);
while (keyPressed == false) {
if(estado == "imagen1" && keyCode == RIGHT && keyPressed == false ){
image(img2,0,0);
estado = "imagen2";
keyPressed = true ;

}

if(estado == "imagen2" && keyCode == LEFT && keyPressed == false){
image(img3,0,0);
estado = "imagen3";
keyPressed = true ;

}

if(estado == "imagen3" && keyCode == DOWN && keyPressed == false){
image(img1,0,0);
estado = "imagen1";
keyPressed = true ;

}

if(estado == "image2" && keyCode == RIGHT && keyPressed == false){
image(img4,0,0);
estado = "image4";
keyPressed = true ;

}

if(estado == "image4" && keyCode == RIGHT && keyPressed == false){
image(img5,0,0);
keyPressed = true ;
}
}
keyPressed = false
}