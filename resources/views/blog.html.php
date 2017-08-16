<?php $this->extend('base') ?>

<?php $this->start('body') ?>

    <br/>
    <div class="container">
        <!-- Navigation bar -->
        <nav class="navbar navbar-inverse bg-inverse">
            <!--<a class="navbar-brand" href="#">Main</a>-->
            <ul class="navbar-right">
                <li class="my-nav-item">
                    Пользователь
                </li>
                <li class="my-nav-button">
                    <button type="button" class="btn btn-default navbar-btn">Войти</button>
                </li>

            </ul>
        </nav>
        <!-- //Navigation bar -->


        <h1 align="center">Задачник</h1>

        <br/>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
            data-target="#addPostModal">
            <span class="glyphicon glyphicon-plus"></span> Добавить задачу
        </button>
        <br/><br/>

        <table id="postsList" class="table table-hover">
            <tr id="tableHeader">
                <th id="usernameCol"><a href="#" class="sortColumn">Имя пользователя</a></th>
                <th id="emailCol"><a href="#" class="sortColumn">E-mail</a></th>
                <th id="textCol"><a href="#" class="sortColumn">Текст задачи</a></th>
                <th id="pictureCol"><a href="#" class="sortColumn">Картинка</a></th>
                <th id="statusCol"><a href="#" class="sortColumn">Статус</a></th>
            </tr>
        </table>
        <div id="addPostModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="addPostForm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Добавить задачу</h3>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Ошибка:</span>
                                <span id='answerText'></span>
                            </div>
                            <div class="form-group">
                              <label for="inputUsername">Имя пользователя</label>
                              <input type="text" data-noempty class="form-control" id="inputUsername" placeholder="Имя пользователя" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail">E-mail</label>
                              <input type="text" data-noempty class="form-control" id="inputEmail" placeholder="E-mail" required>
                              <div class="help-block with-errors"></div>
                            </div>                           
                            <div class="form-group">
                              <label for="inputText">Текст задачи</label>
                              <textarea data-noempty class="form-control" id="inputText" placeholder="Текст задачи" rows="7" required></textarea>
                              <div class="help-block with-errors"></div>
                            </div>                       
                            <div class="form-group">
                              <label for="inputPicture">Картинка (320*240)</label>
                              <textarea data-noempty class="form-control" id="inputPicture" placeholder="Картинка (320*240)" rows="7" required></textarea>
                              <div class="help-block with-errors"></div>
                            </div>                       
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                <button type="submit" class="btn btn-primary" id="addButton">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        <div id="editPostModal" class="modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editPostForm">
                        <div class="modal-header">
                            <h3 class="modal-title">Редактировать задачу</h3>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Ошибка:</span>
                                <span id='answerText'></span>
                            </div>
                            <div class="form-group">
                                <label for="inputUsername">Имя пользователя</label>
                                <input type="text" data-noempty class="form-control" id="inputUsername" placeholder="Имя пользователя" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">E-mail</label>
                                <input type="text" data-noempty class="form-control" id="inputEmail" placeholder="E-mail" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputText">Текст задачи</label>
                                <textarea data-noempty class="form-control" id="inputText" placeholder="Текст задачи" rows="7" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputImage">Картинка (320*240)</label>
                                <input type="file" id="inputImage" /><br/>
                                <div id="imagePreview">
                                    <img id="preview" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Статус&nbsp;&nbsp;<input type="checkbox" id="inputStatus"></label>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" id="closeEditModal" class="btn btn-default" data-dismiss="modal">Не сохранять</button>
                                <button type="submit" class="btn btn-primary" id="editButton">Сохранить</button>
                            </div>
                        </div>
                        <input type='hidden' id="inputId" name='id' value='' />
                    </form>
                </div>
            </div>
        </div>                
    </div>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>