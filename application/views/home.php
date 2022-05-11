<!-- Header -->
<header>
    <div class="container">
        <div class="slider-container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To Our Studio!</div>
                <div class="intro-heading">It's Nice To Meet You</div>
                <a href="#about" class="page-scroll btn btn-xl">Tell Me More</a>
            </div>
        </div>
    </div>
</header>

<section id="about" class="light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>ABOUT</h2>
                    <p>A creative agency based on Candy Land, ready to boost your business with some beautifull templates. Lattes Agency is one of the best in town see more you will be amazed.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</section>

<section class="overlay-dark bg-img1 dark-bg short-section">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-offset-3 col-md-3 mb-sm-30">
                <div class="counter-item">
                    <a href="#course" class="page-scroll">
                        <h6>Cursos</h6>
                    </a>
                </div>
            </div>

            <div class="col-md-3 mb-sm-30">
                <div class="counter-item">
                    <a href="#team" class="page-scroll">
                        <h6>Equipe</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="course" class="light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Cursos</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo voluptatem laborum dolores quas impedit veniam ducimus natus animi quibusdam perferendis in iure cupiditate incidunt, vel optio, distinctio quod consequuntur ratione!</p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            if (!empty($courses)) {
                foreach ($courses as $course) { ?>
                    <div class="col-md-4">
                        <div class="ot-portfolio-item">
                            <figure class="effect-bubba">
                                <img src="<?= base_url() . $course["course_img"] ?>" alt="<?= $course["course_name"] ?>" class="img-responsive" />
                                <figcaption>
                                    <h2><?= $course["course_name"] ?></h2>
                                    <a href="#" data-toggle="modal" data-target="#course_<?= $course["course_id"] ?>">leia mais</a>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="modal fade" id="course_<?= $course["course_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="Modal-label-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="Modal-label-1"><?= $course["course_name"] ?></h4>
                                </div>
                                <div class="modal-body">
                                    <img src="<?= base_url() . $course["course_img"] ?>" alt="<?= $course["course_name"] ?>" class="img-responsive center-block" />

                                    <div class="modal-works"><span>Duração: <?= intval($course["course_duration"]) ?>h</span></div>
                                    <p>
                                        <?= $course["course_description"] ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }

            ?>
        </div>
    </div><!-- end container -->
</section>

<section id="team" class="light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Equipe</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit totam obcaecati molestiae provident cum odit aliquam deserunt maxime quidem et iusto nemo quisquam ratione ducimus dolorem eligendi, nisi sit. Quos.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($team)) {
                foreach ($team as $member) { ?>
                    <div class="col-md-3">
                        <a href="#" data-toggle="modal" data-target="#member_<?= $member["member_id"] ?>">
                            <div class="team-item">
                                <div class="team-image">
                                    <?php
                                    if (!empty($member["member_photo"])) { ?>
                                        <img src="<?= base_url() . $member["member_photo"] ?>" class="img-responsive img-circle" alt="<?= $member["member_name"] ?>">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="team-text">
                                    <h3><?= $member["member_name"]  ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="modal fade" id="member_<?= $member["member_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="Modal-label-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="Modal-label-1"><?= $member["member_name"] ?></h4>
                                </div>

                                <div class="modal-body">
                                    <?php
                                    if (!empty($member["member_photo"])) { ?>
                                        <img src="<?= base_url() . $member["member_photo"] ?>" alt="<?= $member["member_name"] ?>" class="img-responsive center-block" />
                                    <?php
                                    }
                                    ?>
                                    <p><?= $member["member_description"] ?></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php    }
            }
            ?>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>Contact Us</h2>
                    <p>If you have some Questions or need Help! Please Contact Us!<br>We make Cool and Clean Design for your Business</p>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex; justify-content: center;">
            <div class="col-md-10">
                <form name="sentMessage" id="contactForm" novalidate="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name *" id="name" required="" data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Your Email *" id="email" required="" data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Your Message *" id="message" required="" data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <button type="submit" class="btn">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>