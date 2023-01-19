<?php

switch ($data['accountType']) {
  case Core\Controller::AUTH: ?>

          </div>
      </div>
    </div>

    <?php break;
  case Core\Controller::CLIENT: ?>


    <?php break;
  case Core\Controller::ADMIN: ?>

  

    <?php break;
}
?>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Data Table -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4de3040dc0.js" crossorigin="anonymous"></script>

    <!-- External JS -->
    <script type="module" src="<?=SCRIPTS_PATH?>index.js"></script>
    
    <script>
      var Settings = {
        base_url: '<?= SITE_URL ?>'
      }

      console.log("Footer");

      <?php //if ($data['accountType'] == Core\Controller::ADMIN) { ?>

      // let sideNavLink = $("#sidebar .components > li");
      //console.log(<?//= $data['pageId'] ?>//)

      $('<?= $data['pageId'] ?>').addClass('active');

      //for (let i = 0; i < sideNavLink.length; i++) {
      //  const navLink = sideNavLink[i];
      //  if (i === <?//= $data['pageNumber'] ?>//) {
      //    console.log("This is the one");
      //    $(navLink).addClass("active");
      //  }
      //}

      <?php //} else if ($data['accountType'] == Core\Controller::CLIENT) { ?>
      //   $('.navbar-nav').children().each((index, element) => {
      //     if ($(element).find('a').text().toLowerCase() === '<?= $this->getPage() ?>'.toLowerCase()) {
      //       $(element).addClass('active');
      //     }
      //   });
      <?php //} ?>
    
    </script>

    <script type="module" src="<?=SCRIPTS_PATH.$view?>.js"></script>
  </body>
</html>