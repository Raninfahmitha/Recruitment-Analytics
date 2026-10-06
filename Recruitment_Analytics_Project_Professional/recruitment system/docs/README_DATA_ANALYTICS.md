# Recruitment Analytics & Candidate Insights

## Project objective
Transform recruitment application data into actionable HR/recruitment insights using SQL, Python and Power BI, while retaining the original web application as the data-capture layer.

## Tools
HTML/CSS/JavaScript/PHP, MongoDB (application layer), SQL, Python (Pandas/NumPy/Matplotlib), Excel and Power BI.

## Analytics workflow
1. Capture candidate/application data.
2. Clean and validate structured data.
3. Analyze recruitment KPIs with SQL.
4. Perform EDA in Python.
5. Build an interactive Power BI dashboard.
6. Identify source, role, skill and experience trends.

## Important
`data/candidates_sample.csv` is synthetic demo data created for portfolio/demo purposes. Replace it with your real anonymized export when available. The original resume parser remains a placeholder and is not represented as AI parsing.

## How to run
- Open `dashboard/index.html` for the included browser dashboard.
- Run `python/recruitment_eda.py` from the `python` folder after installing pandas, numpy and matplotlib.
- Import the CSV files into Power BI using the instructions in `powerbi/README.md`.
- The original application requires PHP, Composer dependencies and a local MongoDB server.
