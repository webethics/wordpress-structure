<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if($_GET['quiz'] != ""){
?>
<div class="content-footer">
        <button id="btn-export" onclick="exportHTML();">Export to word
            doc</button>
    </div>
<?php } ?>
<div class="mainquiz">
<h2><?php _e('Quiz History', 'tutor'); ?></h2>
<h5><a href="/my-account/my-courses/"><-Back</a></h5>
<style>.mainquiz li:last-child{display:none;}</style>
<?php
global $wpdb;
$id = $_GET['course_id'];
if($id != ""){
$topics = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'topics' AND post_parent = $id ORDER BY ID");
$i =1;
if(empty($topics )){
	echo "<h4>No Quiz added to the class!</h4>";

}
else{
	foreach($topics as $topic){
		echo "<h4>".$i.") ".$topic->post_title."</h4>";
		$quizes = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'tutor_quiz' AND post_parent = $topic->ID");
		echo "<li>";
		foreach($quizes as $quiz){
			if($quiz->post_title != ""){
				echo "<a href='/my-account/quizes/?quiz=".$quiz->ID."'>".ucfirst($quiz->post_title)."</a><li>";
			}
		}
		echo "</li>";
		$i++;
	}
}
}



$quid = $_GET['quiz'];
if($quid != ""){?>
<div id="source-html">	
<?php		
$questions = $wpdb->get_results("SELECT * FROM $wpdb->tutor_quiz_questions WHERE quiz_id = $quid");
foreach ($questions as $question) {
						$question_i++;
						$question_settings = maybe_unserialize($question->question_settings);
						

						$style_display = ($question_layout_view !== 'question_below_each_other' && $question_i == 1) ? 'block' : 'block';
						if ($question_layout_view === 'question_below_each_other'){
							$style_display = 'block';
						}

						$next_question = isset($questions[$question_i]) ? $questions[$question_i] : false;
						?>
                        <div id="quiz-attempt-single-question-<?php echo $question->question_id; ?>" class="quiz-attempt-single-question quiz-attempt-single-question-<?php echo $question_i; ?>" style="display: <?php echo $style_display; ?> ;" <?php echo $next_question ? "data-next-question-id='#quiz-attempt-single-question-{$next_question->question_id}'" : '' ; ?> >

							<?php echo "<input type='hidden' name='attempt[{$is_started_quiz->attempt_id}][quiz_question_ids][]' value='{$question->question_id}' />";


							$question_type = $question->question_type;

							$rand_choice = false;
							if($question_type == 'single_choice' || $question_type == 'multiple_choice'){
								$choice = maybe_unserialize($question->question_settings);
								if(isset($choice['randomize_question'])){
									$rand_choice = $choice['randomize_question'] == 1 ? true : false;
								}
							}

							$answers = tutor_utils()->get_answers_by_quiz_question($question->question_id, $rand_choice);
							$show_question_mark = (bool) tutor_utils()->avalue_dot('show_question_mark', $question_settings);
							$answer_required = (bool) tutils()->array_get('answer_required', $question_settings);

							echo '<h4 class="question-text">';
							if ( ! $hide_question_number_overview){
								echo $question_i. ". ";
							}
							echo stripslashes($question->question_title);
							echo '</h4>';

							if ($show_question_mark){
								echo '<p class="question-marks"> '.__('Marks : ', 'tutor').$question->question_mark.' </p>';
							}

							$question_description = stripslashes($question->question_description);
							if ($question_description){
							    echo "<p class='question-description'>{$question_description}</p>";
                            }
							?>

                            <div class="tutor-quiz-answers-wrap question-type-<?php echo $question_type; ?> <?php echo $answer_required? 'quiz-answer-required':''; ?> ">
								<?php
								if ( is_array($answers) && count($answers) ) {
									foreach ($answers as $answer){
									    $answer_title = stripslashes($answer->answer_title);

										if ( $question_type === 'true_false' || $question_type === 'single_choice' ) {
											?>
                                            <label class="answer-view-<?php echo $answer->answer_view_format; ?>">
                                                <div class="quiz-answer-input-body">
													<?php
													if ($answer->answer_view_format === 'image' || $answer->answer_view_format === 'text_image'){
														?>
                                                        <div class="quiz-answer-image-wrap">
                                                            <img src="<?php echo wp_get_attachment_image_url($answer->image_id, 'full') ?>" />
                                                        </div>
														<?php
													}
													?>
                                                    <div class="quiz-answer-input-bottom">
                                                        <div class="quiz-answer-input-field">
                                                            <input name="attempt[<?php echo $is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>]" type="radio" value="<?php echo $answer->answer_id; ?>">
                                                            <span>&nbsp;</span>
                                                            <?php
                                                                if ($answer->answer_view_format !== 'image'){ echo $answer_title;}
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
											<?php
										}elseif ($question_type === 'multiple_choice'){
											?>
                                            <label class="answer-view-<?php echo $answer->answer_view_format; ?>">


                                                <div class="quiz-answer-input-body">
													<?php if ($answer->answer_view_format === 'image' || $answer->answer_view_format === 'text_image'){ ?>
                                                        <div class="quiz-answer-image-wrap">
                                                            <img src="<?php echo wp_get_attachment_image_url($answer->image_id, 'full') ?>" />
                                                        </div>
                                                    <?php } ?>

                                                    <div class="quiz-answer-input-bottom">
                                                        <div class="quiz-answer-input-field">
                                                            <input name="attempt[<?php echo $is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>][]" type="checkbox" value="<?php echo $answer->answer_id; ?>">
                                                            <span>&nbsp;</span>
                                                            <?php if ($answer->answer_view_format !== 'image'){
                                                                echo $answer_title;
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
											<?php
										}
                                        elseif ($question_type === 'fill_in_the_blank'){
											?>
                                            <p class="fill-in-the-blank-field">
												<?php
												$count_dash_fields = substr_count($answer_title, '{dash}');
												if ($count_dash_fields){

													$dash_string = array();
													$input_data = array();
													for($i=1; $i <=$count_dash_fields; $i ++){
														$dash_string[] = '{dash}';
														$input_data[] = "<input type='text' name='attempt[{$is_started_quiz->attempt_id}][quiz_question][{$question->question_id}][]' class='fill-in-the-blank-text-input' />";
													}
													echo str_replace($dash_string, $input_data, $answer_title);
												}
												?>
                                            </p>
											<?php
										}
                                        elseif ($question_type === 'ordering'){
											?>
                                            <div class="question-type-ordering-item">
                                                <div class="answer-title">
													<?php
													if ($answer->answer_view_format !== 'image'){
														echo "<p class='tutor-quiz-answer-title'>{$answer_title}</p>";
													}
													if ($answer->answer_view_format === 'image' || $answer->answer_view_format === 'text_image'){
														?>
                                                        <div class="quiz-answer-image-wrap">
                                                            <img src="<?php echo wp_get_attachment_image_url($answer->image_id, 'full') ?>" />
                                                        </div>
														<?php
													}
													?>
                                                </div>
                                                <span class="answer-sorting-bar"><i class="tutor-icon-menu-2"></i> </span>
                                                <input type="hidden" name="attempt[<?php echo $is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>][answers][]" value="<?php echo $answer->answer_id; ?>" >
                                            </div>
											<?php
										}
									}

									/**
									 * Question type matchind and image matching
									 */
									if ($question_type === 'matching' || $question_type === 'image_matching'){
										?>
                                        <div class="quiz-answers-type-matching-wrap <?php echo 'answer-type-'.$question_type ?> ">
                                            <div class="quiz-draggable-rand-answers">
												<?php
												$rand_answers = tutor_utils()->get_answers_by_quiz_question($question->question_id, true);
												foreach ($rand_answers as $rand_answer){
													?>
                                                    <div class="quiz-draggable-answer-item">
														<?php
														if ($question_type === 'matching'){
															echo "<span class='draggable-answer-title'>{$rand_answer->answer_two_gap_match}</span>";
														}else{
															echo "<span class='draggable-answer-title'>{$rand_answer->answer_title}</span>";
														}
														?>
                                                        <span class="draggable-answer-icon"> <i class="tutor-icon-menu-2"></i> </span>
                                                        <input type="hidden" name="attempt[<?php echo $is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>][answers][]" value="<?php echo $rand_answer->answer_id; ?>" >
                                                    </div>
													<?php
												}
												?>
                                            </div>

                                            <div class="quiz-answer-matching-items-wrap">
												<?php
												foreach ($answers as $answer){
													?>
                                                    <div class="quiz-answer-item-matching">
                                                        <div class="quiz-answer-matching-title">
															<?php
															if ($question_type === 'matching') {

																if ($answer->answer_view_format !== 'image'){
																	echo "<p class='tutor-quiz-answer-title'>{$answer->answer_title}</p>";
																}
																if ($answer->answer_view_format === 'image' || $answer->answer_view_format === 'text_image'){
																	?>
                                                                    <div class="quiz-answer-image-wrap">
                                                                        <img src="<?php echo wp_get_attachment_image_url($answer->image_id, 'full') ?>" />
                                                                    </div>
																	<?php
																}
															}elseif (intval($answer->image_id)){
																echo '<img src="'.wp_get_attachment_image_url($answer->image_id, 'full').'" />';
															}
															?>
                                                        </div>
                                                        <div class="quiz-answer-matching-droppable"></div>
                                                    </div>
													<?php
												}
												?>

                                            </div>
                                        </div>
										<?php
									}
								}

								/**
								 * For Open Ended Question Type
								 */
								if ($question_type === 'open_ended' || $question_type === 'short_answer'){
									?>
                                    <textarea class="question_type_<?php echo $question_type; ?>" name="attempt[<?php echo
									$is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>]"></textarea>
									<?php
									if ($question_type === 'short_answer') {
										$get_option_meta = tutor_utils()->get_quiz_option($quiz_id);
										if(isset($get_option_meta['short_answer_characters_limit'])){
											if($get_option_meta['short_answer_characters_limit'] != "" ){
												$characters_limit = tutor_utils()->avalue_dot('short_answer_characters_limit', $quiz_attempt_info);
												echo '<p class="answer_limit_desc">  characters remaining <span class="characters_remaining">'.$characters_limit.'</span> </p>';
											}
										}
									}
									if ($question_type === 'open_ended') {
										$get_option_meta = tutor_utils()->get_quiz_option($quiz_id);
										if(isset($get_option_meta['open_ended_answer_characters_limit'])){
											if($get_option_meta['open_ended_answer_characters_limit'] != "" ){
												$characters_limit = $get_option_meta['open_ended_answer_characters_limit'];
												echo '<p class="answer_limit_desc">  characters remaining <span class="characters_remaining">'.$characters_limit.'</span> </p>';
											}
										}
									}
								}


								if ($question_type === 'image_answering'){
									?>
                                    <div class="quiz-image-answering-wrap">
										<?php
										foreach ($answers as $answer){
											?>
                                            <div class="quiz-image-answering-answer">
												<?php
												if (intval($answer->image_id)){
													?>
                                                    <div class="quiz-image-answering-image-wrap">
														<?php echo '<img src="'.wp_get_attachment_image_url($answer->image_id, 'full').'" />'; ?>
                                                    </div>

                                                    <div class="quiz-image-answering-input-field-wrap">
                                                        <input type="text"  name="attempt[<?php echo $is_started_quiz->attempt_id; ?>][quiz_question][<?php echo $question->question_id; ?>][answer_id][<?php echo $answer->answer_id; ?>]" >
                                                    </div>
													<?php
												}
												?>
                                            </div>
											<?php
										}
										?>
                                    </div>
									<?php
								}
								?>

                                <div class="answer-help-block"></div>

                            </div>

							<?php
							if ($question_layout_view !== 'question_below_each_other'){
								if ($next_question){
									?>
                                    <div class="quiz-answer-footer-bar">
                                        <div class="quiz-footer-button">
                                            <button type="button" value="quiz_answer_submit" class="tutor-button
                                        tutor-success tutor-quiz-answer-next-btn"><?php _e( 'Answer &amp; Next Question', 'tutor' ); ?></button>
                                        </div>
                                    </div>
									<?php
								}else{
									?>
                                    <div class="quiz-answer-footer-bar">
                                        <div class="quiz-footer-button">
                                            <button type="submit" name="quiz_answer_submit_btn" value="quiz_answer_submit" class="tutor-button tutor-success"><?php
												_e( 'Submit Quiz', 'tutor' ); ?></button>
                                        </div>
                                    </div>
									<?php
								}
							}
							?>
                        </div>

						<?php
					}
					
?>
</div>
<?php
}
?>
</div>
  <script>
    function exportHTML(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+document.getElementById("source-html").innerHTML+footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'product.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
</script>