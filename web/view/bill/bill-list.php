
<main class="content"> 
  <!-- Header -->
  <div class="page-header">
    <!-- <div class="linear"> -->
      <h1 class="page-title">Bills</h1>

      <!-- New Projects -->
      <a href="<?= SITE_URL ?>/project/new">
        <button type="button" class="btn sm-btn action-btn">
          Create Bill
        </button>
      </a>
  </div>

  <!-- Navigation Tab -->
  <nav class="nav-tab-container">
    <form id="filterTable" action="" class="filter-tab">
      <span class="filter-tab-item active">
        <label for="allStat">All</label>
        <input id="allStat" class="link-btn" type="radio" name="status" value="all" checked>
      </span>
      <!-- <span class="filter-tab-item">
        <label for="doneStat">Done</label>
        <input id="doneStat" class="link-btn" type="radio" name="status" value="done">
      </span>
      <span class="filter-tab-item">
        <label for="ongoingStat">Ongoing</label>
        <input id="ongoingStat" class="link-btn" type="radio" name="status" value="ongoing">
      </span> -->
    </form>

    <!-- Search -->
    <div>
      <div class="search-form">
        <div class="input-container">
          <div class="input-prepend">
            <i class="fa fa-search icon" aria-hidden="true"></i>
          </div>
          <input type="text" name="" id="searchProject" placeholder="Search Bill">
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
        <tbody>
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
        </tbody>
      </table>
    </div>
</main>