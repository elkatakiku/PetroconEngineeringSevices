<main id="dashboard" class="content" data-fill="true">
  <div class="db-content">
    <div class="page-header">
      <h1 class="page-title">Overview</h1>
    </div>

    <div class="ov-card-container">
      <div class="custom-card">
        <div class="overview-card">
          <div class="ov-info">
            <h3 class="ov-title">
              <?= 
                (isset($data['count']['0']['count']) ? $data['count']['0']['count'] : 0) + 
                (isset($data['count']['1']['count']) ? $data['count']['1']['count'] : 0) 
              ?>
            </h3>
            <p class="ov-desc">Total projects</p>
          </div>
          <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
        </div>
      </div>

      <div class="custom-card">
        <div class="overview-card">
          <div class="ov-info">
            <h3 class="ov-title"><?= (isset($data['count']['1']['count']) ? $data['count']['1']['count'] : 0) ?></h3>
            <p class="ov-desc">Done projects</p>
          </div>
          <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
        </div>
      </div>

      <div class="custom-card">
        <div class="overview-card">
          <div class="ov-info">
            <h3 class="ov-title"><?= (isset($data['count']['0']['count']) ? $data['count']['0']['count'] : 0) ?></h3>
            <p class="ov-desc">Ongoing projects</p>
          </div>
          <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
        </div>
      </div>
    </div>

    <!-- Project chart control -->
    <div class="linear">
      <div class="">
        <h5 class="db-sec-header">Projects</h5>
        <p class="db-project-count">
          <?php 
          $total = 0;
          for ($i=0; $i < count($data['chart']['projectsInYear']); $i++) { 
              $total += $data['chart']['projectsInYear'][$i]['count'];
          }
          echo $total;
           ?>
        </p>
      </div>

      <div class="form-group ml-auto mb-0">
        <select class="form-control action-bg slim-btn" name="projectYear">
          <?php 
          $year = $data['chart']['years'][0]['year'];
          $currentYear = (int) date('Y');
          
          while ($year != $currentYear) { ?>

            <option value="">$year</option>
          <?php 
            $year++;} 
            
            if ($year == $currentYear) { ?>
              <option value=""><?= $year ?></option>
            <?php } ?>
        </select>
      </div>
    </div>

    <h3 class="align-right">YEAR 2021</h3>
            
    <div class="chart">
      <div class="bar" data-value="1"></div>
      <div class="bar" data-value="2"></div>
      <div class="bar" data-value="3"></div>
      <div class="bar" data-value="4"></div>
      <div class="bar" data-value="5"></div>
      <div class="bar" data-value="6"></div>
      <div class="bar" data-value="7"></div>
      <div class="bar" data-value="8"></div>
      <div class="bar" data-value="9"></div>
      <div class="bar" data-value="10"></div>
      <div class="bar" data-value="11"></div>
      <div class="bar" data-value="12"></div>
    </div>
  </div>

  <!-- Side contents -->
  <div class="db-side">

      <!-- Calendar -->
<!--    <div class="side-content" id="events">-->
<!--      <h5 class="db-sec-header">Events</h5>-->
<!--      <div class="month">-->
<!--        <ul class="linear space-between">-->
<!--          <li class="prev">&#10094;</li>-->
<!--          <li class="ov-title">--><?//= date('F').' '.date('Y') ?><!--</li>-->
<!--          <li class="next">&#10095;</li>-->
<!--        </ul>-->
<!--      </div>-->
<!--      -->
<!--      <ul class="weekdays">-->
<!--        <li>Su</li>-->
<!--        <li>Mo</li>-->
<!--        <li>Tu</li>-->
<!--        <li>We</li>-->
<!--        <li>Th</li>-->
<!--        <li>Fr</li>-->
<!--        <li>Sa</li>-->
<!--      </ul>-->
<!--      -->
<!--      <ul class="days">-->
<!--        <li></li>-->
<!--        <li></li>-->
<!--        <li></li>-->
<!--        <li></li>-->
<!--        <li class="active">1</li>-->
<!--        <li>2</li>-->
<!--        <li>3</li>-->
<!--        <li>4</li>-->
<!--        <li>5</li>-->
<!--        <li>6</li>-->
<!--        <li>7</li>-->
<!--        <li>8</li>-->
<!--        <li>9</li>-->
<!--        <li>10</li>-->
<!--        <li>11</li>-->
<!--        <li>12</li>-->
<!--        <li>13</li>-->
<!--        <li>14</li>-->
<!--        <li>15</li>-->
<!--        <li>16</li>-->
<!--        <li>17</li>-->
<!--        <li>18</li>-->
<!--        <li>19</li>-->
<!--        <li>20</li>-->
<!--        <li>21</li>-->
<!--        <li>22</li>-->
<!--        <li>23</li>-->
<!--        <li>24</li>-->
<!--        <li>25</li>-->
<!--        <li>26</li>-->
<!--        <li>27</li>-->
<!--        <li>28</li>-->
<!--        <li>29</li>-->
<!--        <li>30</li>-->
<!--        <li>31</li>-->
<!--      </ul>-->
<!--      -->
<!--    </div>-->

    <div class="side-content" id="messages">
      <div class="side-content-header">
        <h5 class="db-sec-header">Messages</h5>
        <button class="btn link-btn">View</button>
      </div>

      <!-- Messages -->
      <div class="chat-box">
        <img class="diplay-image" src="https://scontent.fmnl3-3.fna.fbcdn.net/v/t39.30808-1/299088740_1196979717823399_7518303659892027192_n.jpg?stp=dst-jpg_p320x320&_nc_cat=111&ccb=1-7&_nc_sid=7206a8&_nc_eui2=AeGBrWemSqQRyZqfcNB9uoZBqfeXZDtcsGip95dkO1ywaO9JZXs48xlTpaecf4X3ONJ1hi0ZUko7gLOIcUuNOoyB&_nc_ohc=P3wifdm6izUAX94wFsH&_nc_ht=scontent.fmnl3-3.fna&oh=00_AfA7jwSbP1l70p80Q0glPRDcjsTHTehhSEIu5WLUeGkcLA&oe=638CBBA0" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
        <div class="chat-content">
          <p class="name">Desteen</p>
          <small class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et enim velit. Pellentesque sodales nibh sit amet dolor luctus pretium.</small>
        </div>
      </div>

      <div class="chat-box">
        <img class="diplay-image" src="https://scontent.fmnl3-3.fna.fbcdn.net/v/t39.30808-1/275203833_4833479920081497_9099316294859763547_n.jpg?stp=dst-jpg_p320x320&_nc_cat=103&ccb=1-7&_nc_sid=7206a8&_nc_eui2=AeHzuayGDQAi2LlsvvbJRFH8rsZUSqEcR4muxlRKoRxHifN5rNASFUZaTY1-qHRT1abJbd0CbBi4OxLlvmBZSi5p&_nc_ohc=BFoPowAM2EEAX-GMuoo&_nc_ht=scontent.fmnl3-3.fna&oh=00_AfDeryDBzdu0Vss5WhyNrrfzrvPHFJntqEyk5IqHUpOiXA&oe=638D61AE" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
        <div class="chat-content">
          <p class="name">Momshie</p>
          <small class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et enim velit. Pellentesque sodales nibh sit amet dolor luctus pretium.</small>
        </div>
      </div>
      
      <div class="chat-box">
        <img class="diplay-image" src="https://scontent.fmnl3-4.fna.fbcdn.net/v/t39.30808-1/309500238_5380815078706261_3463532223795883956_n.jpg?stp=dst-jpg_p320x320&_nc_cat=102&ccb=1-7&_nc_sid=7206a8&_nc_eui2=AeFFDXb8j16Q6v_8nnY-l_N542idz-jJfebjaJ3P6Ml95oVX61vYVQqYVxDr_mIAXXsS_yfzXm6BI1UgB0wz8A_7&_nc_ohc=R4-1YSQjsTgAX-ShZJY&_nc_ht=scontent.fmnl3-4.fna&oh=00_AfCqimMaaO9RpxsNXUT8hprKQQ2QQeSoWRZ9QzbbcBPHBA&oe=638D3FE7" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
        <div class="chat-content">
          <p class="name">Elkatakiku</p>
          <small class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et enim velit. Pellentesque sodales nibh sit amet dolor luctus pretium.</small>
        </div>
      </div>

      <div class="chat-box">
        <img class="diplay-image" src="https://scontent.fmnl3-3.fna.fbcdn.net/v/t39.30808-1/317077704_5890770737640833_9143806547782294516_n.jpg?stp=dst-jpg_p320x320&_nc_cat=110&ccb=1-7&_nc_sid=7206a8&_nc_eui2=AeGPsTsQ3ivsGYL193PFbsJSkLcov6d_VlGQtyi_p39WUWADuEczk1SxWl9jPiurBnfvS-3rHDwfmrfNUQo8XkJd&_nc_ohc=CNimpNeWOQoAX-EvPNO&tn=ncxdeSyY_IUTy3C7&_nc_ht=scontent.fmnl3-3.fna&oh=00_AfCvRkmtBbClD3gQMRm_4z3yxC7IYZYHlmjBBp7lnxgJqw&oe=638E4122" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
        <div class="chat-content">
          <p class="name">Takihiro</p>
          <small class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et enim velit. Pellentesque sodales nibh sit amet dolor luctus pretium.</small>
        </div>
      </div>
    </div>
    
  </div>
</main>