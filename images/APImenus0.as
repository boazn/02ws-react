

//#######################################################################
//PARAMETERS PASSED:
APImenuNome   = new Array()  //Contem o Nome dos Menus
APImenuLayout = new Array()  //vertical ou horizontal
APImenuTipo   = new Array()  //fixo ou flutuante 

//#######################################################################
//PARAMETERS CALCULATED:
APImenuItems  = new Array()  //Numero de Items deste Menu
APImenuIndex  = new Array()  //Indice inicial para o Array APIestrutura  
APImenuVisible= new Array()  //Indica se este Menu está visivel ou invisivel: 1 ou 0

APIestrutura  = new Array()  //Contem os Items dos Menus - 3 elementos para cada item
APIarguments  = new Array()

//#######################################################################
function addMENU() {
  APImenuNome.push(APIarguments[0])
  APImenuLayout.push(APIarguments[1])
  APImenuTipo.push(APIarguments[2])
  
  APImenuItems.push((APIarguments.length - 3) / 3)
  APImenuIndex.push(APIestrutura.length)
  APImenuVisible.push(false)
  
  for (i=3; i < APIarguments.length; i++) { 
    APIestrutura.push(APIarguments[i]) 
  }
  while ( APIarguments.length > 0 ) { APIarguments.pop() }
  return(APImenuNome.length - 1)
}

