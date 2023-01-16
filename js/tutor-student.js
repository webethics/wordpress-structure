jQuery(document).ready(function(){ 
			jQuery(document).on("click","#clickcontent",function(){
				jQuery('html, body').animate({
				scrollTop: jQuery("#contentmain").offset().top
				}, 1000);
				return false;
				//jQuery(document).scrollTo('#contentmain');
			})
			/* jQuery(".elementor-nav-menu--dropdown li.current_page_item a").removeClass("elementor-item-active");
			if(jQuery(".elementor-nav-menu--dropdown li.current_page_item").hasClass( "current-menu-item" )){
			jQuery(".elementor-nav-menu--dropdown li.current_page_item.current-menu-item").addClass("current-menu-item1");
			}
			else
			{
				jQuery(".elementor-nav-menu--dropdown li.current_page_item.current-menu-item").removeClass("current-menu-item1");
			}
			jQuery(".elementor-nav-menu--dropdown li.current_page_item").removeClass("current-menu-item");
			jQuery(".elementor-nav-menu--dropdown li").removeClass("current_page_item"); */
			/* jQuery(".tutor-dashboard-menu-settings a").text("Account Settings");
			jQuery(".tutor-dashboard-menu-enrolled-courses a").text("My Classes");
			jQuery(".tutor-dashboard-menu-reviews a").text("My Reviews");
			jQuery(".tutor-dashboard-menu-my-courses a").text("My Classes");
			jQuery(".tutor-dashboard-menu-earning a").text("My Earnings");
			jQuery(".tutor-dashboard-menu-withdraw a").text("Withdraw Earnings");
			jQuery(".tutor-dashboard-menu-question-answer a").text("Student Queries"); */
})