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
                <p class="ov-desc">Finished projects</p>
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

        <?php if ($data['accountType'] != Core\Controller::CLIENT) { ?>

            <div>
              <canvas id="myChart"></canvas>
            </div>

        <?php } else { ?>

            <section class="main-content m-0">

                <table class="mesa mesa-hover" id="usersTable">
                    <thead class="mesa-head">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="tname"><strong>Projects</strong></th>
                        <th scope="col">Progress</th>
                        <th scope="col">Completion Date</th>
                    </tr>
                    </thead>
                    <tbody>

                    <style>
                        .completion-bar {
                            height: 25px;
                        }
                    </style>
                    <tr>
                        <td></td>
                        <td>
                            Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stubouts at 2F and UGF.
                        </td>
                        <td>
                            0%
                        </td>
                        <td>
                            <span style="white-space: nowrap">
                                 -
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stubouts at 2F and UGF.
                        </td>
                        <td class="success-text">
                            <strong>100%</strong>
                        </td>
                        <td>
                            <span style="white-space: nowrap">
                                Jan. 1, 2023 - Feb. 1, 2023
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stubouts at 2F and UGF.
                        </td>
                        <td>
                            25%
                        </td>
                        <td>
                            <span>
                                Jan. 1, 2023 - Feb. 1, 2023
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

        <?php } ?>

    </div>

    <?php if ($data['accountType'] != Core\Controller::CLIENT) { ?>
        <!-- Side contents -->
        <div class="db-side">
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

    <?php } ?>
</main>