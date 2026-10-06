# RecruitIQ Analytics — Run Guide

## Easiest complete demo (recommended)
1. Open this folder in VS Code.
2. Install the **Live Server** extension by Ritwick Dey.
3. Right-click `index.html` → **Open with Live Server**.
4. Use the top navigation:
   - Home — polished landing page
   - Add Candidate — demo candidate entry stored in browser localStorage
   - Candidates — candidate pipeline from the included dataset
   - Analytics — interactive recruitment dashboard
   - Track — candidate application timeline

This mode does **not** require PHP, MongoDB or Composer and is the best way to demonstrate the project in a Data Analyst interview.

## Python analytics
Open VS Code Terminal at `recruitment system/python` and run:

```powershell
pip install pandas numpy matplotlib seaborn openpyxl jupyter
python recruitment_eda.py
jupyter notebook
```

Open `recruitment_eda.ipynb` and use **Run All**.

## SQL
Open `sql/recruitment_analysis.sql` in your SQL client. The included queries analyze candidate volume, source performance, selection rate, roles and skills.

## Power BI
Open Power BI Desktop → Get Data → Text/CSV → `data/candidates_sample.csv`. Import `data/candidate_skills.csv` if needed. Use `powerbi/measures.dax` for the DAX measures and `powerbi/data_model.txt` for the model.

## Optional PHP/MongoDB backend
The original backend remains under `backend/`. It is optional for the analytics demo and requires PHP, Composer's MongoDB driver/package, and a local MongoDB instance. The browser demo is intentionally self-contained so the full project can be shown without those dependencies.
