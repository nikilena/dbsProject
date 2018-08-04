package dbs;

import java.io.BufferedReader;
import java.io.FileReader;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

public class TestDataGenerator
{
	private static String row = "";

	private static String removeSemicolon(String s)
	{
		if (s != null && s.length() > 0 && s.charAt(s.length() - 1) == ';') s = s.substring(0, s.length() - 1);
		return s;
	}

	public static void main(String args[])
	{
		try
		{
			Class.forName("oracle.jdbc.driver.OracleDriver");
			String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
			String user = "a1467981";
			String pass = "1467981";
			ResultSet rs = null;
			// First row in inserSQL.txt is an altering statement to change the date format of the database
			// boolean variable used to remember if the first row was executed or not
			boolean firstRowExecuted = false;

			// establish connection to database
			Connection con = DriverManager.getConnection(database, user, pass);
			Statement stmt = con.createStatement();

			// read all inserts from file
			FileReader fr = new FileReader("index.txt");
			BufferedReader br = new BufferedReader(fr);

			while ((row = br.readLine()) != null)
			{
				row = removeSemicolon(row);
				try
				{
					if (!firstRowExecuted)
					{
						stmt.execute(row);
						firstRowExecuted = true;
					}
					stmt.executeUpdate(row);
				}
				catch (Exception e)
				{
					System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
				}
			}

			// check number of datasets in uni table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM uni");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (uni): " + count);
			}

			// check number of datasets in gebaude table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM gebaude");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (gebaude): " + count);
			}

			// check number of datasets in raum table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM raum");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (raum): " + count);
			}

			// check number of datasets in professor table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM professor");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (professor): " + count);
			}

			// check number of datasets in lehrveranstaltung table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM lehrveranstaltung");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (lehrveranstaltung): " + count);
			}

			// check number of datasets in vorlesung table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM vorlesung");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (vorlesung): " + count);
			}

			// check number of datasets in uebung table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM uebung");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (uebung): " + count);
			}

			// check number of datasets in prufung table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM prufung");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (prufung): " + count);
			}

			// check number of BookingOffice in student table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM student");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (student): " + count);
			}

			// check number of datasets in prufungmachen table
			rs = stmt.executeQuery("SELECT COUNT(*) FROM prufungmachen");
			if (rs.next())
			{
				int count = rs.getInt(1);
				System.out.println("Number of datasets (prufungmachen): " + count);
			}

			// clean up connections
			rs.close();
			stmt.close();
			con.close();
			br.close();
		}
		catch (Exception e)
		{
			System.err.println(e.getMessage());
		}
	}
}