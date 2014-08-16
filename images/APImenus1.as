
//############################
//# DECLARE GLOBAL VARIABLES #
//############################
APIinsideItem = false
APItimer = 0

//######################
//# GENERATE MENU ITEMS#
//######################
function APIgenerateItems() {
  ItemMatriz._visible = false
  
  nivel = 1
  for ( indice=0; indice < APImenuNome.length; indice++ ) {
    MENU   = APImenuNome[indice]
    index  = APImenuIndex[indice]
    items  = APImenuItems[indice]
    layout = APImenuLayout[indice]
    
    for (k = 0; k < items; k++) {
      ItemName = MENU + "#" + indice + "#" + k
      Texto    = APIestrutura[index + 3*k]
      ItemMatriz.duplicateMovieClip(ItemName,nivel++)  
      eval(ItemName)._visible = false   
      if ( layout == "horizontal" ) { eval(ItemName)._width = 100 }
      eval(ItemName).Texto = Texto    
    }
  }
}
APIgenerateItems() 


//################
//# DISPLAY MENU #
//################
function APIdisplayMenu(indice,posx,posy) { 
  MENU   = APImenuNome[indice]
  items  = APImenuItems[indice]
  layout = APImenuLayout[indice]

  //For all items in this menu:
  for (k = 0; k < items; k++) {
    ItemName = MENU + "#" + indice + "#" + k
    eval(ItemName)._x = posx
    eval(ItemName)._y = posy
    eval(ItemName)._visible = true

    if ( layout == "horizontal" ) { posx += eval(ItemName)._width - 1 }
                             else { posy += eval(ItemName)._height - 2 } 
  }
  APImenuVisible[indice]= true
}
 

//#########
//# CLICK #
//#########
function APIclick(ItemName) {
  Parms = ItemName.split("#")
  MENU     = Parms[0]
  indice   = Parms[1]
  k        = Parms[2]
  index = APImenuIndex[indice]
  Link  = APIestrutura[index + 3*k + 1]
  if ( Link != "" ) { getURL(Link,"_top") }

  NextMenu = APIestrutura[index + 3*k + 2]
  if ( NextMenu != "" ) {
    NextIndex = APIfindIndex(NextMenu)
    //Se NextMenu estiver ligado, desliga-o e vice-versa
    if ( APImenuVisible[NextIndex] == true ) { APIhideMenu(NextIndex) }
                                       else  { APIdisplayChildMenu(ItemName) }
  }
}


//#############
//# MOUSEOVER #
//#############
function APImouseover(ItemName) {
  APIinsideItem = true
  APIhideMenus(ItemName)
  APIdisplayChildMenu(ItemName)
}
//############
//# MOUSEOUT #
//############
function APImouseout(ItemName) {
  APIinsideItem = false
}

function APIenterFrame() {
  APItimer++
  if ( APItimer > 10 ) {
    APItimer = 0
    APIhideMenus("null")
  }
} 

//######################
//# DISPLAY CHILD MENU #
//######################
function APIdisplayChildMenu(ItemName) {
  Parms = ItemName.split("#")
  MENU     = Parms[0]
  indice   = Parms[1]
  k        = Parms[2]
  index    = APImenuIndex[indice]
  layout   = APImenuLayout[indice]
  NextMenu = APIestrutura[index + 3*k + 2]

  //Se o menu actual é horizontal, o próximo menu cresce sempre para baixo, 
  //caso contrário cresce para o lado
  if ( NextMenu == "" ) return
 
  //Precisamos determinar o indice do NextMenu
  NextIndex = APIfindIndex(NextMenu)
    
  dx = eval(ItemName)._x 
  dy = eval(ItemName)._y
  dh = eval(ItemName)._height
  dw = eval(ItemName)._width

  if ( layout == "horizontal" ) {
    posx = dx
    posy = dy + dh - 1
  } else {
    posx = dx + dw - 1
    posy = dy
  }
  if ( MENU == "MENU0" ) { posx += 50 }
  APIdisplayMenu(NextIndex,posx,posy) 

}


//#############################
//# FIND INDEX FROM MENU NAME #
//#############################
function APIfindIndex(NextMenu) {
  for ( NextIndex in APImenuNome ) { 
    if ( APImenuNome[NextIndex] == NextMenu ) { return(NextIndex) }
  }
}

//#################################################################################
// Hide todos os Menus, excepto os Pais, do current Menu, recebido como parâmetro #
// Um menu é pai do current menu, se o seu nome é uma substring do Current Menu   #
//#################################################################################
function APIhideMenus(ItemName) {
  //trace(ItemName)
  if ( ItemName == "null" && APIinsideItem == true ) return
  
  Parms = ItemName.split("#")
  MENUparent = Parms[0]

  //loop no numero de menus
  for ( indice in APImenuNome ) {
    MENU = APImenuNome[indice]
    tipo = APImenuTipo[indice]
    if ( MENUparent.indexOf(MENU) == -1 && tipo != "fixo" ) { APIhideMenu(indice) }
  }
}

//#############
//# HIDE MENU #
//#############
function APIhideMenu(indice) {
  MENU  = APImenuNome[indice]
  items = APImenuItems[indice]
  
  for (k = 0; k < items; k++) { 
    ItemChild = MENU + "#" + indice + "#" + k
    eval(ItemChild)._visible = false
  }
  APImenuVisible[indice]= false
}

