import pandas as pd
import matplotlib.pyplot as plt
df=pd.read_csv("../data/candidates_sample.csv")
print(df.info());print(df.isna().sum());print("Duplicates:",df.duplicated().sum())
total=len(df);shortlisted=df.Shortlisted.sum();selected=(df.Status=="Selected").sum()
print({"Total":total,"Shortlisted":int(shortlisted),"Selected":int(selected),"ShortlistingRate%":round(shortlisted/total*100,2),"SelectionRate%":round(selected/total*100,2)})
source=df.groupby("Source").agg(Applications=("CandidateID","count"),Selected=("Status",lambda x:(x=="Selected").sum()));source["SelectionRate%"]=(source.Selected/source.Applications*100).round(2);print(source.sort_values("SelectionRate%",ascending=False))
skills=df.assign(Skill=df.Skills.str.split(", ")).explode("Skill");top=skills.Skill.value_counts().head(10);print(top)
for name,series,title,xlab in [("applications_by_role",df.JobRole.value_counts(),"Applications by Job Role","Applications"),("selection_rate_by_source",source["SelectionRate%"].sort_values(),"Selection Rate by Source","Selection Rate (%)"),("top_skills",top.sort_values(),"Top Candidate Skills","Candidates")]:
 plt.figure(figsize=(9,5));series.plot(kind="barh" if name!="applications_by_role" else "bar");plt.title(title);plt.xlabel(xlab);plt.tight_layout();plt.savefig(name+".png",dpi=160);plt.close()
