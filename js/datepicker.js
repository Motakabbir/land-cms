// Tim Tryzbiak (6/19/02)
// Original:  Kedar R. Bhave (softricks@hotmail.com)
// Web Site:  http://www.softricks.com -->
//
// This oject was adapted from Bhave's calendar.  However, it's been through
// several changes since then

var weekend = [0,6];
var fontface = "Verdana";
var fontsize = 2;

var gNow = new Date();
var ggWinCal;

isNav = (navigator.appName.indexOf("Netscape") != -1) ? true : false;
isIE = (navigator.appName.indexOf("Microsoft") != -1) ? true : false;

Calendar.Months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
Calendar.DOMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // non-leap year
Calendar.lDOMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // leap year

// Constructor
//
// Initializes the calendar
function Calendar(p_item, p_WinCal, p_month, p_year, p_format) 
{
	if ((p_month == null) && (p_year == null))	return;

	if (p_WinCal == null)
		this.gWinCal = ggWinCal;
	else
		this.gWinCal = p_WinCal;
	
	if (p_month == null) 
		p_month = 0;
		
	
	
	this.gMonthName = Calendar.get_month(p_month);
	this.gMonth = new Number(p_month);

	this.gYear = p_year;
	this.gFormat = p_format;
	this.gBGColor = "white";
	this.gFGColor = "black";
	this.gTextColor = "black";
	this.gHeaderColor = "black";
	this.gReturnItem = p_item;
}

// Set the calendar object functions
Calendar.get_month = Calendar_get_month;
Calendar.get_daysofmonth = Calendar_get_daysofmonth;
Calendar.calc_month_year = Calendar_calc_month_year;

// get_month
//
// Returns the name of the month
function Calendar_get_month(monthNo) 
{
	return Calendar.Months[monthNo];
}

// get_daysofmonth
//
// Returns the days of the month keeping in mind leap years
// 
// 1.Years evenly divisible by four are normally leap years, except for... 
// 2.Years also evenly divisible by 100 are not leap years, except for... 
// 3.Years also evenly divisible by 400 are leap years. 
function Calendar_get_daysofmonth(monthNo, p_year) 
{
	if ((p_year % 4) == 0) {
		if ((p_year % 100) == 0 && (p_year % 400) != 0)
			return Calendar.DOMonth[monthNo];
	
		return Calendar.lDOMonth[monthNo];
	} else
		return Calendar.DOMonth[monthNo];
}

// get_calc_month_year
//
// Calculates the next/previous month and year combo
// 
// Will return an 1-D array with 1st element being the calculated month 
// and second being the calculated year 
// after applying the month increment/decrement as specified by 'incr' parameter.
// 'incr' will normally have 1/-1 to navigate thru the months.
function Calendar_calc_month_year(p_Month, p_Year, incr) 
{
	var ret_arr = new Array();
	
	if (incr == -1) {
		// B A C K W A R D
		if (p_Month == 0) {
			ret_arr[0] = 11;
			ret_arr[1] = parseInt(p_Year) - 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) - 1;
			ret_arr[1] = parseInt(p_Year);
		}
	} else if (incr == 1) {
		// F O R W A R D
		if (p_Month == 11) {
			ret_arr[0] = 0;
			ret_arr[1] = parseInt(p_Year) + 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) + 1;
			ret_arr[1] = parseInt(p_Year);
		}
	}
	
	return ret_arr;
}

// This is for compatibility with Navigator 3, we have to create and 
// discard one object before the prototype object exists.
new Calendar();

// getMonthlyCalendarTable
//
// This is the table that will be filled by the days of the month
Calendar.prototype.getMonthlyCalendarTable = function() 
{
	var vHeader_Code = "";
	var vData_Code = "";
	var vCode = "";

	vHeader_Code = this.getDayTitles();
	vData_Code = this.getDays();

	vCode = vCode + "<table border='1' cellpadding='1' cellspacing='0' bgcolor='" + this.gBGColor + "' style='border-color:gray'>";
	vCode = vCode + vHeader_Code + vData_Code;
	vCode = vCode + "</table>";
	
	return vCode;
}

// getDayTitles
//
// Builds the title for each column (day) of our calendar
Calendar.prototype.getDayTitles = function() 
{
	var vCode = "";
	
	vCode = vCode + "<tr>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Sun</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Mon</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Tue</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Wed</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Thu</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Fri</b></font></td>";
	vCode = vCode + "<td width='14%' height='28' align='center' valign='middle' bgcolor='" + this.gHeaderBGColor + "'><font size='" + fontsize + "' face='" + fontface + "' color='" + this.gHeaderColor + "'><b>Sat</b></font></td>";
	vCode = vCode + "</tr>";
	
	return vCode;
}

// getDays
//
// Builds the days of our calendar
Calendar.prototype.getDays = function() 
{
	var vDate = new Date();
	vDate.setDate(1);
	vDate.setMonth(this.gMonth);
	vDate.setFullYear(this.gYear);

	var prevMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, -1);

	var vFirstDay = vDate.getDay();
	var vDay = 1;
	var vLastDay = Calendar.get_daysofmonth(this.gMonth, this.gYear);
	var vLastMonthLastDay = Calendar.get_daysofmonth(prevMMYYYY[0], prevMMYYYY[1]);
	var vOnLastDay = 0;
	var vCode = "<tr>";

	// Build the filler for the area before the first of this month
	for (i = vLastMonthLastDay - vFirstDay + 1; i <= vLastMonthLastDay; i++) 
	{
		vCode = vCode + "<td width='14%' height='25' align='center' valign='middle' " + this.weekendFormat(i - (vLastMonthLastDay - vFirstDay + 1)) + ">";
		vCode = vCode + "<font size='" + fontsize + "' face='" + fontface + "' color='gray'>" + i + "</font>";
		vCode = vCode + "</td>";
	}

	// Build the rest of the first week
	for (i = vFirstDay; i < 7; i++) 
	{
		vCode = vCode + "<td width='14%' height='25' align='center' valign='middle' " + this.weekendFormat(i) + ">";
		vCode = vCode + "<font size='" + fontsize + "' face='" + fontface + "'>";
		vCode = vCode +	"<a href='javascript:window.opener.document." + this.gReturnItem + ".value=\"" + this.dateFormat(vDay) + "\";window.close();'>";
		vCode = vCode + this.dayFormat(vDay);
		vCode = vCode + "</a>"; 
		vCode = vCode + "</font>";
		vCode = vCode + "</td>";
		vDay = vDay + 1;
	}
	
	vCode = vCode + "</tr>";

	// Write the rest of the weeks
	for (i = 2; i < 7; i++) 
	{
		vCode = vCode + "<tr>";

		for (j = 0; j < 7; j++) 
		{
			vCode = vCode + "<td width='14%' height='25' align='center' valign='middle' " + this.weekendFormat(j) + ">";
			vCode = vCode + "<font size='" + fontsize + "' face='" + fontface + "'>";
			vCode = vCode +	"<a href='javascript:window.opener.document." + this.gReturnItem + ".value=\"" + this.dateFormat(vDay) + "\";window.close();'>";
			vCode = vCode + this.dayFormat(vDay);
			vCode = vCode + "</a>"; 
			vCode = vCode + "</font>";
			vCode = vCode + "</td>";
			vDay = vDay + 1;

			if (vDay > vLastDay) 
			{
				vOnLastDay = 1;
				break;
			}
		}

		if (j == 6)
			vCode = vCode + "</tr>";
			
		if (vOnLastDay == 1)
			break;
	}
	
	// Fill up the rest of last week with proper blanks, so that we get proper square blocks
	for (i = 1; i < (7-j); i++) {
		vCode = vCode + "<td width='14%' height='25' align='center' valign='middle' " + this.weekendFormat(j + i) + ">";
		vCode = vCode + "<font size='" + fontsize + "' face='" + fontface + "' color='gray'>" + i + "</font>";
		vCode = vCode + "</td>";
	}
	
	return vCode;
}

// show
//
// Used to draw the calendar
Calendar.prototype.show = function() 
{
	var vCode = "";
	
	p_path = arguments[0];
	
	this.gWinCal.document.open();

	var prevMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, -1);
	var prevMM = prevMMYYYY[0];
	var prevYYYY = prevMMYYYY[1];

	var nextMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, 1);
	var nextMM = nextMMYYYY[0];
	var nextYYYY = nextMMYYYY[1];
	
	// Setup the page...
	this.gWinCal.document.writeln("<html>");
	this.gWinCal.document.writeln("<head><title>Calendar</title>");
	this.gWinCal.document.writeln("</head>");

	this.gWinCal.document.writeln("<body link='" + this.gLinkColor + "' vlink='" + this.gLinkColor + "' alink='" + this.gLinkColor + "' text='" + this.gTextColor + "' leftmargin='5' rightmargin='5' topmargin='5' bottommargin='5' marginwidth='5' marginheight='5'>");

	// Show navigation buttons
	this.gWinCal.document.writeln("<table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='" + this.gControlsBGColor + "'>");
	this.gWinCal.document.writeln("<tr><td><font size='" + fontsize + "' face='" + fontface + "'><b>" + this.gMonthName + " " + this.gYear+ "</b><br></td></tr>");
	this.gWinCal.document.writeln("<tr><td>");
	this.gWinCal.document.writeln("<table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='" + this.gControlsBGColor + "'>");
	this.gWinCal.document.writeln("<tr>");
	this.gWinCal.document.writeln("<td width='55' height='22' align='left'><font size='" + fontsize + "' face='" + fontface + "'><a href='javascript:window.opener.Build(\"" + this.gReturnItem + "\", \"" + this.gMonth + "\", \"" + (parseInt(this.gYear)-1) + "\", \"" + this.gFormat + "\", \"" + p_path + "\");'><img src='" + p_path + "b_prev_year.gif' width='52' height='18' border='0' alt='Previous Year'><\/a></font></td>");
	this.gWinCal.document.writeln("<td width='62' height='22' align='left'><font size='" + fontsize + "' face='" + fontface + "'><a href='javascript:window.opener.Build(\"" + this.gReturnItem + "\", \"" + prevMM + "\", \"" + prevYYYY + "\", \"" + this.gFormat + "\", \"" + p_path + "\");'><img src='" + p_path + "b_prev_month.gif' width='60' height='18' border='0' alt='Previous Month'><\/a></font></td>");
	this.gWinCal.document.writeln("<td height='22' align='center'><font size='" + fontsize + "' face='" + fontface + "'><a href='javascript:window.opener.Build(\"" + this.gReturnItem + "\", \"" + gNow.getMonth() + "\", \"" + gNow.getFullYear() + "\", \"" + this.gFormat + "\", \"" + p_path + "\");'><img src='" + p_path + "b_sun.gif' width='22' height='18' border='0' alt='Today'></a></font></td>");
	this.gWinCal.document.writeln("<td width='62' height='22' align='right'><font size='" + fontsize + "' face='" + fontface + "'><a href='javascript:window.opener.Build(\"" + this.gReturnItem + "\", \"" + nextMM + "\", \"" + nextYYYY + "\", \"" + this.gFormat + "\", \"" + p_path + "\");'><img src='" + p_path + "b_next_month.gif' width='60' height='18' border='0' alt='Next Month'><\/a></font></td>");
	this.gWinCal.document.writeln("<td width='55' height='22' align='right'><font size='" + fontsize + "' face='" + fontface + "'><a href='javascript:window.opener.Build(\"" + this.gReturnItem + "\", \"" + this.gMonth + "\", \"" + (parseInt(this.gYear)+1) + "\", \"" + this.gFormat + "\", \"" + p_path + "\");'><img src='" + p_path + "b_next_year.gif' width='52' height='18' border='0' alt='Next Year'><\/a></font></td>");
	this.gWinCal.document.writeln("</tr>");
	this.gWinCal.document.writeln("</table>");
	this.gWinCal.document.writeln("</td></tr>");
	this.gWinCal.document.writeln("<tr><td bgcolor='#FFFFFF'><img src='../images/blank.gif' width='1' height='5'></td></tr>");
	this.gWinCal.document.writeln("<tr><td align='center' valign='middle'>");

	// Get the complete calendar code for the month..
	vCode = this.getMonthlyCalendarTable();
	this.gWinCal.document.writeln(vCode);

	this.gWinCal.document.writeln("</td></tr>");
	this.gWinCal.document.writeln("</table>");
	this.gWinCal.document.writeln("</body></html>");
	this.gWinCal.document.close();
}

// dayFormat
//
// If we're dealing today, format the tay
Calendar.prototype.dayFormat = function(vday) 
{
	var vNowDay = gNow.getDate();
	var vNowMonth = gNow.getMonth();
	var vNowYear = gNow.getFullYear();

	if (vday == vNowDay && this.gMonth == vNowMonth && this.gYear == vNowYear)
		return ("<font color='red'><b>" + vday + "</b></font>");
	else
		return (vday);
}

// weekendFormat
//
// If we're dealing with a day that is one of the weekend days
// format the cell a little different
Calendar.prototype.weekendFormat = function(vday) 
{
	var i;

	// Return special formatting for the weekend day.
	for (i = 0; i < weekend.length; i++) {
		if (vday == weekend[i])
			return (" bgcolor='" + this.gWeekendBGColor + "'");
	}
	
	return "";
}

// dateFormat
//
// Formats the date base on how the user wanted it
Calendar.prototype.dateFormat = function(p_day) 
{
	var vData;
	var vMonth = 1 + this.gMonth;
	vMonth = (vMonth.toString().length < 2) ? "0" + vMonth : vMonth;
	var vMon = Calendar.get_month(this.gMonth).substr(0,3).toUpperCase();
	var vFMon = Calendar.get_month(this.gMonth).toUpperCase();
	var vY4 = new String(this.gYear);
	var vY2 = new String(vY4.substr(2,2));
	var vDD = (p_day.toString().length < 2) ? "0" + p_day : p_day;

	switch (this.gFormat) {
		case "MM\/DD\/YYYY" :
			vData = vMonth + "\/" + vDD + "\/" + vY4;
			break;
		case "MM\/DD\/YY" :
			vData = vMonth + "\/" + vDD + "\/" + vY2;
			break;
		case "MM-DD-YYYY" :
			vData = vMonth + "-" + vDD + "-" + vY4;
			break;
		case "MM-DD-YY" :
			vData = vMonth + "-" + vDD + "-" + vY2;
			break;

		case "DD\/MON\/YYYY" :
			vData = vDD + "\/" + vMon + "\/" + vY4;
			break;
		case "DD\/MON\/YY" :
			vData = vDD + "\/" + vMon + "\/" + vY2;
			break;
		case "DD-MON-YYYY" :
			vData = vDD + "-" + vMon + "-" + vY4;
			break;
		case "DD-MON-YY" :
			vData = vDD + "-" + vMon + "-" + vY2;
			break;

		case "DD\/MONTH\/YYYY" :
			vData = vDD + "\/" + vFMon + "\/" + vY4;
			break;
		case "DD\/MONTH\/YY" :
			vData = vDD + "\/" + vFMon + "\/" + vY2;
			break;
		case "DD-MONTH-YYYY" :
			vData = vDD + "-" + vFMon + "-" + vY4;
			break;
		case "DD-MONTH-YY" :
			vData = vDD + "-" + vFMon + "-" + vY2;
			break;

		case "DD\/MM\/YYYY" :
			vData = vDD + "\/" + vMonth + "\/" + vY4;
			break;
		case "DD\/MM\/YY" :
			vData = vDD + "\/" + vMonth + "\/" + vY2;
			break;
		case "DD-MM-YYYY" :
			vData = vDD + "-" + vMonth + "-" + vY4;
			break;
		case "DD-MM-YY" :
			vData = vDD + "-" + vMonth + "-" + vY2;
			break;

		default :
			vData = vMonth + "\/" + vDD + "\/" + vY4;
	}

	return vData;
}

// ShowCalendar()
//
// Opens the calendar in a seperate window
//
// Arguments:
// HTML Control to autofill - document.<formname>.<controlname>
// Initial Date				- Initial date from which the month will be determined
// Format					- date format
function show_calendar() 
{

	var Today = new Date();

	p_item = arguments[0];
	
	if (arguments[2] == null)
		p_format = "MM/DD/YYYY";
	else
		p_format = arguments[2];


	if (arguments[1] == null)
		var ldCurrentDate = new Date();
	else
	{
		if (!IsDate(arguments[1])){		
			var ldCurrentDate = new Date(); 
		}
		else 
		{
			if  (p_format == "MM/DD/YYYY")
				var ldCurrentDate = new Date(arguments[1]);
			else
				var ldCurrentDate = new Date();
				
			//alert("else = " + ldCurrentDate); // <==
		}
	}

	p_month = ldCurrentDate.getMonth();
	p_year = ldCurrentDate.getFullYear();
	if (p_year < 1980) p_year = p_year + 100;

	vWinCal = window.open("", "Calendar", "width=283,height=235,status=no,resizable=no,top=200,left=200");
	vWinCal.opener = self;
	ggWinCal = vWinCal;
	
	p_path = arguments[3];

	Build(p_item, p_month, p_year, p_format, p_path);
}

// Build()
//
// Builds the calendar that will be displayed
//
// Arguments:
// HTML Control to autofill - document.<formname>.<controlname>
// Initial Date				- Initial date from which the month will be determined
// Format					- date format
function Build(p_item, p_month, p_year, p_format, p_path) 
{
	var p_WinCal = ggWinCal;
	gCal = new Calendar(p_item, p_WinCal, p_month, p_year, p_format);

	// Customize your Calendar here..
	gCal.gBGColor="white";
	gCal.gLinkColor="black";
	gCal.gTextColor="black";
	gCal.gHeaderColor="#FFFFFF";
	gCal.gHeaderBGColor="#263B81";
	gCal.gWeekendBGColor="#F0F4FA";
	gCal.gControlsBGColor="#FFFFFF";

	// Choose appropriate show function
	gCal.show(p_path);
}

// IsDate()
//
// Determines if the date is valid or not
//
// Arguments:
// sDate - Date to be checked
//
// Returns: True/False
function IsDate(sDate) 
{
  var DVReturn = ValidateDate(sDate);
  return DVReturn[0];
}

// IsDateForm()
//
// Determines if the date is valid or not and update the form
// field appropriately
//
// Arguments:
// roDateField - Date field to be checked
//
// Returns: True/False
function IsDateFormField(roDateField) 
{
	return true;
	var DVReturn = ValidateDate(roDateField.value);
	if (DVReturn[0])
	{
		roDateField.value = (DVReturn[1].getMonth() + 1) + "/" + DVReturn[1].getDate() + "/" + DVReturn[1].getFullYear();
		return true;
	}
	else
	{
		roDateField.value = "";
		return false;
	}
}

// ValidateDate()
//
// Determines if the date is valid or not
//
// Arguments:
// sDate - Date to be checked
//
// Returns: 
// [0] = true/false
// [1] = date object
function ValidateDate(rsDate) 
{ 
	var MonthAbbr, MonthIndex, Rex, lbValid, lnYear, loNewDate=0

	// Remove any suffixes that are on the date
	Rex = new RegExp("(st|nd|rd|th)", "i")
	rsDate = rsDate.replace(Rex, ' ') 

	// Replace month abbreviations with the right number
	Rex = /([^A-Z]*)([A-Z]{1,3})(.*)/i 
	if (Rex.test(rsDate)) 
	{
		MonthAbbr = rsDate.replace(Rex, '$2').toUpperCase()
		MonthIndex = " JAN FEB MAR APR MAY JUN JUL AUG SEP OCT NOV DEC".indexOf(' ' + MonthAbbr)
		rsDate = rsDate.replace(Rex, (1 + MonthIndex / 4)+' $1'+' $3')
	}

	// Split into the three fields and build the new date
	Rex = /^(\d+)\D+(\d+)\D+(\d+)$/ 
	rsDate = rsDate.replace(Rex, '$3 $1 $2') 
	lbValid = Rex.test(rsDate) 
	if (lbValid) with (RegExp) 
	{ 
		lnYear = +$1
		if (lnYear < 100) lnYear += (lnYear < 60 ? 2000:1900)      // optional century line
		with (loNewDate = new Date(lnYear, $2 - 1, $3))
		lbValid = ((getMonth()==$2-1) && (getDate()==$3))  
	} 

	// Return the valid flag and date object
	return [lbValid, loNewDate]
}



