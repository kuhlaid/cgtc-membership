<?php
/* Class for handling iCal feeds */
class QiCal {

	/**
	 * @abstract Creates an iCal feed which can be added to calendar applications such as Google Calendar and Microsoft Outlook to create a visual representation of the AV requests.
	 * @author w. Patrick Gale April 2009
	 * $type 
	 */
	public function _output($strEventsList='', $strCalendarName='iCal Feed', $strFileName='ical_feed', $strCalendarDescription='iCal Feeds', $strCalendarFeedUrl='') {
		
		//$this->createEvents();
		
		header('Content-type: text/calendar');
		header('Content-Disposition: attachment; filename="'.$strFileName.'.ics"');
		
	$content = <<<MLS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//{$strCalendarName}//NONSGML v1.0//EN
X-WR-CALNAME:{$strCalendarName}
X-WR-TIMEZONE:US/Eastern
X-ORIGINAL-URL:{$strCalendarFeedUrl}
X-WR-CALDESC:{$strCalendarDescription}
CALSCALE:GREGORIAN
METHOD:PUBLISH
{$strEventsList}END:VCALENDAR
MLS;
		
		echo $content;
		exit;
	}
	
	public function createEvents(){
		$space = '      ';
		foreach ($posts as $post) {
			$start_time = date('Ymd\THis', $post->post_date);
			$end_time = date('Ymd\THis', $post->post_date + (60 * 60));
			$summary = $post->post_title;
			$permalink = get_permalink($post->ID);
			if (isset($_GET['content']))
			{
				$content = str_replace(',', '\,', str_replace('\\', '\\\\', str_replace("\n", "\n" . $space, strip_tags($post->post_content))));
				$content = $permalink . "\n" . $space . "\n" . $space . $content;
			}
			else
				$content = $permalink;
			
		$this->strEventsList .= <<<MLS
BEGIN:VEVENT
DTSTART:$start_time
DTEND:$end_time
SUMMARY:$summary
DESCRIPTION:$content
END:VEVENT
MLS;
		}
	}
}
?>