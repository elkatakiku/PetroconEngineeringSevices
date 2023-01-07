
<main class="content"> 
  <!-- Header -->
  <div class="page-header">
    <!-- <div class="linear"> -->
      <h1 class="page-title">Projects</h1>

      <!-- New Projects -->
      <a href="<?= SITE_URL ?>/project/new">
        <button type="button" class="btn sm-btn action-btn">
          Create Project
        </button>
      </a>
    <!-- </div> -->

    <!-- <div class="dropdown">         
      <button class="btn btn-sm dropdown-toggle neutral-outline-btn" type="button" data-toggle="dropdown" aria-expanded="false">
          Filter
      </button>

      <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item">All</span>
          <span class="dropdown-item">Done</span>
          <span class="dropdown-item">Ongoing</span>
      </div>
    </div> -->
    <!-- <form id="filterTable" action="" class="linear">
      <div class="input-container">
        <select id="statusSelect" class="input-type" name="status" title="Filter projects by status">
          <option value="" disabled>Select Status</option>
          <option value="all">All</option>
          <option value="done">Done</option>
          <option value="ongoing">Ongoing</option>
        </select>

        <div class="input-append">
          <span class="material-icons icon">
              filter_alt
          </span>
        </div>
      </div>
    </form> -->
  </div>

  <!-- Navigation Tab -->
  <nav class="nav-tab-container">
    <form id="filterTable" action="" class="filter-tab">
      <span class="filter-tab-item active">
        <label for="allStat">All</label>
        <input id="allStat" class="link-btn" type="radio" name="status" value="all" checked>
      </span>
      <span class="filter-tab-item">
        <label for="doneStat">Done</label>
        <input id="doneStat" class="link-btn" type="radio" name="status" value="done">
      </span>
      <span class="filter-tab-item">
        <label for="ongoingStat">Ongoing</label>
        <input id="ongoingStat" class="link-btn" type="radio" name="status" value="ongoing">
      </span>
    </form>

    <!-- Search -->
    <div>
      <div class="search-form">
        <div class="input-container">
          <div class="input-prepend">
            <i class="fa fa-search icon" aria-hidden="true"></i>
          </div>
          <input type="text" name="" id="searchProject" placeholder="Search Project">
        </div>
      </div>
    </div>
  </nav>


  <div id="samp">
    
  </div>

    <style>

      .main-content {
        padding-top: 0;
      }
    </style>

    <!-- Project Table -->
    <div class="main-content">
      <table class="mesa" id="projectsTable">
        <thead class="mesa-head">
          <tr>
            <th scope="col"></th>
            <th scope="col" class="tname projectName">Project</th>
            <th scope="col" class="company">Company</th>
            <th scope="col">Status</th>
            <!-- <th scope="col"></th> -->
          </tr>
        </thead>
        <!-- <tbody>
          <tr onclick="viewData('');">
            <th scope="row">1</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr>
            <th scope="row">1</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr class="">
            <th scope="row">2</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr class="">
            <th scope="row">2</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr class="">
            <th scope="row">2</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
          <tr class="">
            <th scope="row">2</th>
            <td>
              <p><strong>Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</strong></p>
              <small>Robinsons Palace, Antipolo City</small>
            </td>
            <td>21/11/2022</td>
            <td>Done</td>
            <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
          </tr>
        </tbody> -->
      </table>
    </div>
</main>