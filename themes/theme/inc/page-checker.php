<?php
/*
 * Template Name: Checker page
 */
get_header(); ?>
<div class="single plagiarism">
    <div class="container">
        <main>
            <div class="business">
                <div class="business-row business__plagiarism">
                    <h1 class="single__title"><?php the_title(); ?></h1>
                    <?php the_post(); the_content(); ?>

                    <div class="business-dropzone" id="dropzone">

                        <div class="business-dropzone-textares">

                            <div class="editing-wrap">
                                <textarea class="business-text textToCheck" id="business-textToCheck" rows="10" placeholder="Paste Your Text Here"></textarea>


                                <!-- result -->
                                <div class="business_result-wrap">
                                    <div class="business_result-data">

                                    </div>
                                </div>
                            </div>

                            <?php
							/**
							 * ********************************
							 * Response after submit in JSON:
							 * {"error":"","error_code":0,"text":"this is a test word doc created with word 97. some fancy fonts some fancy fonts some fancy fonts some fancy fonts some fancy fonts heading1heading2a simple tableooo that will do for now.","percent":"33.6","highlight":[["1","2"],["4","4"],["6","24"],["28","28"],["31","31"]],"matches":[{"url":"https:\/\/fontmeme.com\/fancy-fonts\/","percent":"17.8","highlight":[["1","2"],["7","7"],["11","12"],["14","15"]]},{"url":"http:\/\/www.learnnc.org\/lp\/editions\/webwriting\/711","percent":"24.3","highlight":[["17","18"],["20","21"],["23","24"],["28","28"],["31","31"]]},{"url":"https:\/\/github.com\/elastic\/elasticsearch-mapper-attachments\/issues\/82","percent":"59.9","highlight":[["4","4"],["6","24"]]}]}
							 * ********************************
							 */?>

                            <div class="business-dropzone-helpfull">
                                Or Upload Your File: .pdf, .doc, .docx, .txt.
                            </div>

                            <form action="/wp-admin/admin-ajax.php" class="dropzone needsclick dz-clickable active" id="business-upload">
                                <input type="hidden" name="action" value="essay_checker_upload">
                                <div class="fallback">
                                    <input name="file" type="file" id="upload-file"/>
                                </div>
                                <div class="dz-message needsclick business-row">
                                    <img src="<?= get_template_directory_uri(); ?>/assets/img/cloud-computing.svg" alt="" />
                                    <div class="dropzone-title">
                                        Drop Your File Here <br>
                                        or Click to Upload
                                    </div>
                                </div>
                            </form>

                        </div>

                        <button type="submit" id="business-essayCheck" class="business-btn essayCheck" onclick="ga('send', 'event', 'Checker', 'main_button', 'first');">Check my essay</button>

                        <div id="result-top">

                            <div class="business_result-sub-data business-row">
                                <div class="business-col-sm-6">
                                    <div class="business-fileform">
                                        <input id="upload" type="file" name="photo" accept=".doc,.docx,.pdf,.txt" />
                                        <p class="business-filename" id="filename">Nasreddin and the Smell of Soup.pdf</p>
                                        <label class="business-label" for="upload" id="filelabel">Browse new file</label>
                                    </div>
                                    <p><b>The length of the text:</b> <span class="text-len">160</span> (No spaces: <span class="text-no-space">190</span>)</p>
                                </div>
                                <div class="business-col-sm-6">
                                    <div class="business_result-uniq">
                                        <div class="uniq-text">The uniqueness of the text: <span class="uniq-percent">2.2 %</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="preload"></div>
                        <div class="file-error"></div>
                    </div>

                    <div id="result-bottom">
                        <!-- btns group -->
                        <div class="business_result-btns">
                            <a class="result_btn orange" href="" onclick="ga('send', 'event', 'CTA', 'checker', 'footer')">Do you need plagiarism-free content?</a>
                            <a class="result_btn blue" href="/checker/" onclick="removeResult('clear');ga('send', 'event', 'Checker', 'new_report', 'footer')">Get new report</a>
                        </div>
                        <!-- btns group -->
                        <!-- tables -->
                        <div class="table-result-wrap">
                            <table class="result-table">
                                <thead>
                                <tr>
                                    <th>Sources:</th>
                                    <th>Similarity index:</th>
                                    <th>View in the text:</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <!--end -tables -->
                        </div>

                        <!-- btns group -->
                        <div class="business_result-btns">
                            <a class="result_btn orange" href="" onclick="ga('send', 'event', 'CTA', 'checker', 'footer')">Do you need plagiarism-free content?</a>
                            <a class="result_btn blue" href="/checker/" onclick="removeResult('clear');ga('send', 'event', 'Checker', 'new_report', 'footer')">Get new report</a>
                        </div>
                        <!-- btns group -->
                    </div>

                </div>
            </div>


            <!-- Preview DropZone Template -->

            <div id="preview-template" style="display: none;">

                <div class="dz-preview dz-file-preview">
                    <div class="dz-image"><img data-dz-thumbnail /></div>

                    <div class="dz-details">
                        <div class="dz-size"><span data-dz-size></span></div>
                        <div class="dz-filename"><span data-dz-name></span></div>
                    </div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>

                    <div class="dz-success-mark">

                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                            <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                            <title>Check</title>
                            <desc>Created with Sketch.</desc>
                            <defs></defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                            </g>
                        </svg>

                    </div>
                    <div class="dz-error-mark">

                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                            <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                            <title>error</title>
                            <desc>Created with Sketch.</desc>
                            <defs></defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                    <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php do_action('checker_popup'); // Show plagiarism checker popup form Hooks.class.php ?>
<?php get_footer(); ?>