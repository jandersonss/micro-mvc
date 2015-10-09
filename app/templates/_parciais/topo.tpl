<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Exemplo de Uso do mvc</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manual <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <?php foreach ($list_paginas as $i=>$row) {?>
              <a href="<?php echo geraLink('paginas/detalhes',$row['COD_PAGINA'], $row['TITULO_PAGINA']); ?>"><?php echo ($i+1); ?> - <?php echo $row['TITULO_PAGINA']; ?></a>
              <?php } ?>
            </li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contatos<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="/contatos.html">Contatos</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>