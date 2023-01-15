<main class="content"> 
  <pre>
    <?= var_dump($data) ?>
  </pre>
  <!-- Header -->
  <div class="page-header">
    <!-- <div class="linear"> -->
      <h1 class="page-title">Users</h1>

      <!-- New users -->
      <a href="<?= SITE_URL ?>/user/new">
        <button type="button" class="btn sm-btn action-btn">
          Create User
        </button>
      </a>
  </div>

  <!-- Navigation Tab -->
  <nav class="nav-tab-container">
    <form id="filterTable" action="" class="filter-tab">
      <span class="filter-tab-item active">
        <label for="allStat">All</label>
        <input id="allStat" class="link-btn" type="radio" name="type" value="all" checked>
      </span>
      <span class="filter-tab-item">
        <label for="doneStat"><?= ucwords($data['acctTypes'][1]['name']).'s' ?></label>
        <input id="doneStat" class="link-btn" type="radio" name="type" value="<?= $data['acctTypes'][1]['id'] ?>">
      </span>
      <!-- <span class="filter-tab-item">
        <label for="ongoingStat">Workers</label>
        <input id="ongoingStat" class="link-btn" type="radio" name="type" value="2">
      </span> -->
      <span class="filter-tab-item">
        <label for="ongoingStat"><?= ucwords($data['acctTypes'][3]['name']).'s'?></label>
        <input id="ongoingStat" class="link-btn" type="radio" name="type" value="<?= $data['acctTypes'][3]['id'] ?>">
      </span>
    </form>

    <!-- Search -->
    <div>
      <div class="search-form">
        <div class="input-container">
          <div class="input-prepend">
            <i class="fa fa-search icon" aria-hidden="true"></i>
          </div>
          <input type="text" name="" id="searchUser" placeholder="Search User">
        </div>
      </div>
    </div>
  </nav>

  <style>

    .main-content {
      padding-top: 0;
    }
  </style>

  <!-- Users Table -->
  <div class="main-content">
    <table class="mesa" id="usersTable">
      <thead class="mesa-head">
        <tr>
          <th scope="col"></th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Username</th>
          <th scope="col">Password</th>
          <th scope="col"></th>
        </tr>
      </thead>
    </table>
  </div>
</main>