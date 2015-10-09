          <h2 class="sub-header">Páginas</h2>
          <div class="table-responsive">

            <table class="table table-striped">
              <thead>

                <tr>
                  <th width="150"></th>
                  <th>#</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($list_paginas as $row) {?>
                <tr>
                  <td><a href="<?php echo geraLink('paginas/detalhes',$row['COD_PAGINA'], $row['TITULO_PAGINA']); ?>">[ Ver a página ]</a></td>
                  <td><?php echo $row['COD_PAGINA']; ?></td>
                  <td><?php echo $row['TITULO_PAGINA']; ?></td>
                  <td><?php echo substr(strip_tags($row['TEXTO_PAGINA']) , 0 , 200); ?></td>
                  <td><?php echo $row['STATUS_PAGINA']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>