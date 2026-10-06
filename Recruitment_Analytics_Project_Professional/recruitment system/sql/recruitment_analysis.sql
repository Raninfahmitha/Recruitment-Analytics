-- Recruitment Analytics SQL (MySQL-compatible)
SELECT COUNT(*) AS total_candidates FROM candidates;
SELECT JobRole,COUNT(*) applications FROM candidates GROUP BY JobRole ORDER BY applications DESC;
SELECT Status,COUNT(*) candidates FROM candidates GROUP BY Status ORDER BY candidates DESC;
SELECT ROUND(100*SUM(Shortlisted)/COUNT(*),2) shortlisting_rate FROM candidates;
SELECT ROUND(100*SUM(Status='Selected')/COUNT(*),2) selection_rate FROM candidates;
SELECT Source,COUNT(*) applications,SUM(Status='Selected') selected_candidates,ROUND(100*SUM(Status='Selected')/COUNT(*),2) selection_rate FROM candidates GROUP BY Source ORDER BY selection_rate DESC;
SELECT ExperienceYears,COUNT(*) candidates,SUM(Status='Selected') selected_candidates,ROUND(100*SUM(Status='Selected')/COUNT(*),2) selection_rate FROM candidates GROUP BY ExperienceYears ORDER BY ExperienceYears;
SELECT Skill,COUNT(*) candidate_count FROM candidate_skills WHERE Status IN ('Shortlisted','Interview','Selected') GROUP BY Skill ORDER BY candidate_count DESC LIMIT 10;
SELECT JobRole,ROUND(AVG(ResumeScore),2) avg_resume_score FROM candidates GROUP BY JobRole ORDER BY avg_resume_score DESC;
SELECT LEFT(ApplicationDate,7) application_month,COUNT(*) applications FROM candidates GROUP BY LEFT(ApplicationDate,7) ORDER BY application_month;
SELECT City,COUNT(*) candidates FROM candidates GROUP BY City ORDER BY candidates DESC;
SELECT Education,COUNT(*) selected_candidates FROM candidates WHERE Status='Selected' GROUP BY Education ORDER BY selected_candidates DESC;
