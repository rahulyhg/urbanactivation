<table style="border:0;width:300px;">
	<tr>
        <td>
<%			'display selected city links
			grp = "apartment"
			Set objectdata2  = server.CreateObject("adodb.recordset")
			'sqlquery = "select COUNT(p.cityID) as total, p.cityID, c.cityName, c.seo from tblProperty p, tblCity c where p.cityID=c.cityID and p.Post=1 and groupName='" & grp & "' group by p.cityID, c.cityName, c.seo"
			sqlquery = "select COUNT(p.citySeo) as total, c.cityName, c.seo from tblProperty p, tblCity c where p.citySeo=c.seo and p.Post=1 and c.post=1 and p.TypeID=" & getTableFieldID("tblPropertyType", "TypeID", "Type", "Apartment") & " group by c.cityName, c.seo order by total desc"
			objectdata2.Open sqlquery , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.eof %>
				<a href="<%=server_path%>buy-off-the-plan-apartments-<%=objectdata2("seo")%>">Buy off the plan Apartments <%=objectdata2("cityName")%></a><br />
<%				objectdata2.movenext
				'response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'>&nbsp;|&nbsp;</font>")
			wend %>
		</td>
        <td>
<%			'display selected city links
			grp = "investment"
			Set objectdata2  = server.CreateObject("adodb.recordset")
			'sqlquery = "select COUNT(p.cityID) as total, p.cityID, c.cityName, c.seo from tblProperty p, tblCity c where p.cityID=c.cityID and p.Post=1 and groupName='" & grp & "' group by p.cityID, c.cityName, c.seo"
			sqlquery = "select COUNT(p.citySeo) as total, c.cityName, c.seo from tblProperty p, tblCity c where p.citySeo=c.seo and p.Post=1 and c.post=1 group by c.cityName, c.seo order by total desc"
			objectdata2.Open sqlquery , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.eof %>
				<a href="<%=server_path%>investment-property-<%=objectdata2("seo")%>">Investment Property <%=objectdata2("cityName")%></a><br />
<%				objectdata2.movenext
				'response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'>&nbsp;|&nbsp;</font>")
			wend %>
		</td>
	</tr>
    <tr>
        <td>
<%			grp = "apartment"
			Set objectdata2  = server.CreateObject("adodb.recordset")
			sql = "select distinct s.stateName, s.stateAbbrev, s.seq_no, s.seo from tblState s, tblProperty p where p.State=s.stateAbbrev and s.post=1 and groupName='" & grp & "' order by s.seq_no"
			objectdata2.Open sql , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.EOF %>
				<a href="<%=server_path%>buy-off-the-plan-apartments-<%=replace(objectdata2("seo"), "_", "-")%>">Buy off the plan Apartments <%=objectdata2("stateName")%></a><br />
<%				objectdata2.movenext
				'if not objectdata2.eof then response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'>&nbsp;|&nbsp;</font>")
			wend %>
		</td>
        <td>
<%			grp = "investment"
			Set objectdata2  = server.CreateObject("adodb.recordset")
			sql = "select distinct s.stateName, s.stateAbbrev, s.seq_no, s.seo from tblState s, tblProperty p where p.State=s.stateAbbrev and s.post=1 and groupName='" & grp & "' order by s.seq_no"
			objectdata2.Open sql , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.EOF %>
				<a href="<%=server_path%>investment-property-<%=replace(objectdata2("seo"), "_", "-")%>">Investment Property <%=objectdata2("stateName")%></a><br />
<%				objectdata2.movenext
				'response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'>&nbsp;|&nbsp;</font>")
			wend %>
		</td>
	</tr>
<!--    <tr>
        <td>
<%			'---------- Apartments for Sale
			grp = "apartment"
			'display selected suburbs
			Set objectdata2  = server.CreateObject("adodb.recordset")
			sqlquery = "select s.suburbName, s.seo from tblSuburb s where s.post=1 and s.groupName='" & grp & "'"
			objectdata2.Open sqlquery , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.eof %>
				<a href="<%=server_path%>buy-off-the-plan-apartments-<%=objectdata2("seo")%>">Apartments for sale <%=objectdata2("suburbName")%></a><br />
<%				objectdata2.movenext
				'response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'>&nbsp;|&nbsp;</font>")
			wend %>
		</td>
    	<td>
<%			'---------- Investment Property
			grp = "investment"
			'display selected suburbs
			Set objectdata2  = server.CreateObject("adodb.recordset")
			sqlquery = "select s.suburbName, s.seo from tblSuburb s where s.post=1 and s.groupName='" & grp & "'"
			objectdata2.Open sqlquery , Session("Connection"), 0, 2 , &H0001
			while not objectdata2.eof %>
				<a href="<%=server_path%>investment-property-<%=objectdata2("seo")%>">Investment Property <%=objectdata2("suburbName")%></a><br />
<%				objectdata2.movenext
				'response.write("<font style='color: #009DDB;font-size: 1em;font-weight: bold;'></font><br />")
			wend %>
		</td>
    </tr>-->
</table>





