          <h2 class="sub-header">Contatos</h2>
          <div class="table-responsive">

            <table class="table table-striped">
              <thead>

                <tr>
                  <th width="150"></th>
                  <th>#</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($list_contatos as $row) {?>
                <tr>
                  <td><?php echo $row['COD_CONTATO']; ?></td>
                  <td><?php echo $row['DESC_CATEGORIA']; ?></td>
                  <td><?php echo $row['NOME_CONTATO']; ?></td>
                </tr>
                <?php }/*
                echo "<pre>";
                print_r(get_defined_vars());
                echo "</pre>";*/
                ?>
              </tbody>
            </table>

            <ul class="pagination">
              <?php
              $aux_link = 'contatos';
              paginacao2($results_tot, $results_parc, $qtd_pag, $num_pag, $aux_link);
              ?>
            </ul>
          </div>