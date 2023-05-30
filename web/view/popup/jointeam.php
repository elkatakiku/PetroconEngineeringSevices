<div class="pcontainer popup-lg">
    <div class="pcontent">
        <div class="pheader">
            <span class="material-icons">group_work</span>
            <h2 class="ptitle">Choose from team</h2>
            <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <style>
            .search-bar {
                position: relative;
            }

            [data-search] {
                margin-top: 5px;
                border-radius: 0 0 5px 5px;
                box-shadow: 0 10px 8px -5px rgba(0, 0, 0, .3);
                position: absolute;
                background-color: white;
                width: 100%;
                max-height: calc( 100vh - 50vh );
                right: 0;
                overflow-y: auto;
            }

            .ps {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 5px 8px;
                /*margin: 0 -8px;*/
            }

            .ps:hover {
                background-color: #f4f4f4;
                cursor: pointer;
            }

            /*.ps-id {*/
                /*display: none;*/
            /*}*/

            .ps-name {
                font-size: 14px;
            }

            .ps-email {
                font-size: 12px;
                color: gray;
            }
        </style>

        <div class="pbody">
            <div class="form-group search-bar" id="searchPeople">
                <div class="input-container">
                    <input type="search" placeholder="Add by email or search by name">
                    <div class="input-append">
                        <button type="button" class="btn action-btn slim-btn" id="addPerson">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="peopleSuggestion" data-search="#searchPeople">
<!--                    <div class="ps">-->
<!--                        <span class="ps-id" hidden>adasds</span>-->
<!--                        <span class="ps-name">Lamzon, Eliezer</span>-->
<!--                        <span class="ps-email">lamzonelizer1@gmail.com</span>-->
<!--                    </div>-->
<!--                    <div class="ps">-->
<!--                        <span class="ps-id" hidden>adasds</span>-->
<!--                        <span class="ps-name">Lamzon, Eliezer</span>-->
<!--                        <span class="ps-email">lamzonelizer1@gmail.com</span>-->
<!--                    </div>-->
<!--                    <div class="ps">-->
<!--                        <span class="ps-id" hidden>adasds</span>-->
<!--                        <span class="ps-name">Lamzon, Eliezer</span>-->
<!--                        <span class="ps-email">lamzonelizer1@gmail.com</span>-->
<!--                    </div>-->
                </div>
            </div>


            <div class="form-group">
                <label for="">Selected People</label>

                <div class="mesa-container">
                    <table  class="mesa" id="joinTeamTable">
                        <thead class="mesa-head">
                        <tr>
<!--                            <th></th>-->
                            <th scope="col" class="tname" style="width: 50%;">Name</th>
                            <th scope="col">Email Address</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
<!--                            <td>1</td>-->
                            <td>Lamzon, Elie</td>
                            <td>lamzonelizer1@gmail.com</td>
                            <td>
                                <div class="action-cell-content">
                                    <button class="btn outline-danger-btn sm-btn icon-btn remove-btn">Remove</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    <p>Add a person to the list</p>
                </div>
            </div>
        </div>

        <div class="pfooter">
            <button type="button" class="btn action-btn">Add</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </div>
    </div>
</div>
