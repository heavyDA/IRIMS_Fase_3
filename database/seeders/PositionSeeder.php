<?php

namespace Database\Seeders;

use App\Jobs\PositionJob;
use App\Models\Master\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DUS",
                "position_name" => "Corporate Secretary Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "USC",
                "position_name" => "Corporate Communication Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "USB",
                "position_name" => "Corporate Branding Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "USS",
                "position_name" => "Corporate BOD Office Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DUI",
                "position_name" => "Internal Audit Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UIO",
                "position_name" => "Operational Audit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UIB",
                "position_name" => "Business & Supporting Audit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UIS",
                "position_name" => "Special Audit & Advisory Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DUC",
                "position_name" => "Legal & Compliance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UCB",
                "position_name" => "Legal Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UCR",
                "position_name" => "Regulation & Compliance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DUL",
                "position_name" => "Legal Aid & Institutional Relation Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ULA",
                "position_name" => "Legal Aid Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ULI",
                "position_name" => "Institutional Relation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DUE",
                "position_name" => "Customer Experience Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UEE",
                "position_name" => "Customer Experience Design & Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UEI",
                "position_name" => "Customer Insight & Quality Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "UEA",
                "position_name" => "Airport Service Delivery Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DSS",
                "position_name" => "Corporate Strategy & Performance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SSS",
                "position_name" => "Corporate Strategy & Planning Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SSR",
                "position_name" => "Corporate Performance & Research Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SCT",
                "position_name" => "Corporate Transformation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DSB",
                "position_name" => "Business Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SBB",
                "position_name" => "Business Development & Asset Optimization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SBS",
                "position_name" => "Strategic Partnership Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DSA",
                "position_name" => "Asset Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SAA",
                "position_name" => "Asset Evaluation & Readiness Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "SAI",
                "position_name" => "Asset Information Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DST",
                "position_name" => "Technology & Digitalization Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "STE",
                "position_name" => "Enterprise Application Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "STA",
                "position_name" => "Airport Application Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "STI",
                "position_name" => "IT Infrastructure & Network Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "STC",
                "position_name" => "Cyber Security, Business Intelligence & Analytics Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DCC",
                "position_name" => "Commercial Strategy & Policy Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CCA",
                "position_name" => "Aero Commercial Strategy & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CCN",
                "position_name" => "Non-Aero Commercial Strategy & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DCA",
                "position_name" => "Aero Commercial Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CAD",
                "position_name" => "Domestic-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CAA",
                "position_name" => "Asia Pacific-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CAE",
                "position_name" => "EMEA-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DCN",
                "position_name" => "Non-Aero Commercial Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNM",
                "position_name" => "Marketing & Promotion Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNR",
                "position_name" => "Retail Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNT",
                "position_name" => "Tenant Relation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNV",
                "position_name" => "Visual Merchandise Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNF",
                "position_name" => "Fitting Out Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "CNC",
                "position_name" => "Cargo & Property Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DOP",
                "position_name" => "Airport Operation Strategy & Policy Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OPP",
                "position_name" => "Airport Operation Planning & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OPD",
                "position_name" => "Airport Operation Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OPL",
                "position_name" => "Airside & Landside Operation Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OPS",
                "position_name" => "Airside & Landside Operation Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DOS",
                "position_name" => "Airport Safety Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OSA",
                "position_name" => "Airport Safety Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OSS",
                "position_name" => "Airport Safety Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DOA",
                "position_name" => "Airport Security Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OAA",
                "position_name" => "Airport Security Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "OAS",
                "position_name" => "Airport Security Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DTE",
                "position_name" => "Airport Engineering Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TED",
                "position_name" => "Airport Engineering & Design Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TEM",
                "position_name" => "Airport Environmental Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DTF",
                "position_name" => "Airport Facility Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TFC",
                "position_name" => "Civil Airside Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TFT",
                "position_name" => "Terminal Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TFN",
                "position_name" => "Non-Terminal & Landscape Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DTM",
                "position_name" => "Airport Equipment Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TMM",
                "position_name" => "Mechanical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TME",
                "position_name" => "Electrical Divison Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TMC",
                "position_name" => "Electronic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DTA",
                "position_name" => "Airport Costruction & Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "TAA",
                "position_name" => "Airport Construction & Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DKF",
                "position_name" => "Corporate Finance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KFT",
                "position_name" => "Treasury Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KFF",
                "position_name" => "Capital Financing Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KFM",
                "position_name" => "Capital Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DKR",
                "position_name" => "Financial Controller & Reporting Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KRB",
                "position_name" => "Business Planning & Analysis Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KRS",
                "position_name" => "Strategic Management Report Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KRF",
                "position_name" => "Financial Accounting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "KRT",
                "position_name" => "Tax Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DMR",
                "position_name" => "Governance & Risk Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "MRG",
                "position_name" => "Governance Assurance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "MRE",
                "position_name" => "Enterprise Risk Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DHO",
                "position_name" => "Organization Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HOO",
                "position_name" => "Organization Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HOP",
                "position_name" => "Performance & Industrial Relations Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HOC",
                "position_name" => "Culture & Innovation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DHH",
                "position_name" => "Human Capital Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HHT",
                "position_name" => "Talent Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HHS",
                "position_name" => "Human Capital Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DHL",
                "position_name" => "Learning & Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HLD",
                "position_name" => "People Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HLL",
                "position_name" => "Learning Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DHP",
                "position_name" => "Procurement & Logistic Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HPP",
                "position_name" => "Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HPL",
                "position_name" => "Logistic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DHC",
                "position_name" => "Corporate Social Responsibility & General Service Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HCC",
                "position_name" => "Corporate Social Responsibility Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HCE",
                "position_name" => "Environmental, Social & Governance Performance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HCF",
                "position_name" => "Office Facilities Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "HCA",
                "position_name" => "Office Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA",
                "position_name" => "Head of Airport Construction Area A",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.PC",
                "position_name" => "Project Construction Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.PM",
                "position_name" => "Project Monitoring & Evaluation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.XP",
                "position_name" => "CGK 1 Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.YP",
                "position_name" => "CGK 2 Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.PI",
                "position_name" => "SUB & SRG Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.PN",
                "position_name" => "PGK, TKG, TJQ & BKS Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADA.V.PT",
                "position_name" => "PDG & PKU Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB",
                "position_name" => "Head of Airport Construction Area B",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PC",
                "position_name" => "Project Construction Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PM",
                "position_name" => "Project Monitoring & Evaluation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PI",
                "position_name" => "DPS Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PN",
                "position_name" => "DJJ Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PT",
                "position_name" => "UPG Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADB.V.PE",
                "position_name" => "PNK, PKY, BPN & BDJ Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADE",
                "position_name" => "Head of Project Engineering",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADE.V.PB",
                "position_name" => "Project Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADE.V.PF",
                "position_name" => "Project Infrastructure Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADE.V.PE",
                "position_name" => "Project Mechanical, Electrical & Electronic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADF",
                "position_name" => "Head of Project Finance & General Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADF.V.PA",
                "position_name" => "Project Accounting & Budgeting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADF.V.PG",
                "position_name" => "Project General Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADF.V.PS",
                "position_name" => "Project Treasury Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADP",
                "position_name" => "Head of Project Procurement & Legal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADP.V.PP",
                "position_name" => "Project Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADP.V.PL",
                "position_name" => "Project Legal & Contract Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "DSC",
                "position_name" => "Corporate Transformation Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DU",
                "position_name" => "Lead Transformation Office Direktorat Utama",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DS",
                "position_name" => "Lead Transformation Office Direktorat Strategi & Pengembangan Teknologi",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DK",
                "position_name" => "Lead Transformation Office Direktorat Komersial",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DO",
                "position_name" => "Lead Transformation Office Direktorat Operasi",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DT",
                "position_name" => "Lead Transformation Office Direktorat Teknik",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DM",
                "position_name" => "Lead Transformation Office Direktorat Keuangan & Manajemen Risiko",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADT.DH",
                "position_name" => "Lead Transformation Office Direktorat Human Capital",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADS",
                "position_name" => "Head of Shared Service Center",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADS.V.TAR",
                "position_name" => "Treasury & Account Receivable Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADS.V.BAS",
                "position_name" => "Budgeting & Accounting Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADS.V.OSP",
                "position_name" => "Operation & Services Procurement Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADS.V.BSP",
                "position_name" => "Business & Supporting Procurement Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR",
                "position_name" => "Head of Enterprise Resource Planning Project",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.PMA",
                "position_name" => "Project Monitoring & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.TIN",
                "position_name" => "Technology & Integration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.HCR",
                "position_name" => "Human Capital Management Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.FAR",
                "position_name" => "Financial Accounting Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.CRR",
                "position_name" => "Commercial & REM Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.AMR",
                "position_name" => "Asset & Material Management Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PST",
                "unit_code" => "ADR.V.FER",
                "position_name" => "Facility & Equipment Maintenance Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG I",
                "unit_code" => "CGR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.AO",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.OO",
                "position_name" => "Assistant Deputy Airside Operation Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.OX",
                "position_name" => "T1 & Cargo Airside Operation Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AX",
                "position_name" => "T1 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.OC",
                "position_name" => "Cargo Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.OV",
                "position_name" => "T2 & T3 Airside Operation Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VY",
                "position_name" => "T2 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VZ",
                "position_name" => "T3 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.RF",
                "position_name" => "Assistant Deputy Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.FP",
                "position_name" => "Airport Rescue & Fire Fighting Operations Performance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PA",
                "position_name" => "Aircraft Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PR",
                "position_name" => "Building Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.FM",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance & Prevention Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.MM",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ME",
                "position_name" => "Airport Rescue & Fire Fighting Exercise & Prevention Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.SP",
                "position_name" => "Assistant Deputy Airport Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SL",
                "position_name" => "Screening & Surveillances Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LX",
                "position_name" => "T1 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LY",
                "position_name" => "T2 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LZ",
                "position_name" => "T3 Domestic Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.IZ",
                "position_name" => "T3 International Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LT",
                "position_name" => "CCTV Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.PP",
                "position_name" => "Protection Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.PV",
                "position_name" => "Perimeter & Vital Object Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PO",
                "position_name" => "Non-Terminal & Traffic Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PD",
                "position_name" => "Cargo Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PS",
                "position_name" => "T1 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PC",
                "position_name" => "T2 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PT",
                "position_name" => "T3 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.LP",
                "position_name" => "Assistant Deputy Landside Operation Services & Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.PL",
                "position_name" => "Landside & Cargo Operation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LL",
                "position_name" => "Landside Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LO",
                "position_name" => "Cargo Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LD",
                "position_name" => "TOD Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.PT",
                "position_name" => "Public Transportation Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TA",
                "position_name" => "APMS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TI",
                "position_name" => "Mass Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TP",
                "position_name" => "Personal Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SXY",
                "position_name" => "T1 & T2 Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SX",
                "position_name" => "T1 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SY",
                "position_name" => "T2 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.EZ",
                "position_name" => "T3 Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ED",
                "position_name" => "T3 Domestic Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EI",
                "position_name" => "T3 International Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.AC",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.CA",
                "position_name" => "Assistant Deputy Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.AI",
                "position_name" => "International Aero Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.IP",
                "position_name" => "International PJP4U, PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.IS",
                "position_name" => "International Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.IC",
                "position_name" => "International PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.AD",
                "position_name" => "Domestic Aero Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DD",
                "position_name" => "Domestic PJP4U, PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DS",
                "position_name" => "Domestic Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DP",
                "position_name" => "Domestic PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.DN",
                "position_name" => "Assistant Deputy Non-Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.NR",
                "position_name" => "Retail & Concession Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.RR",
                "position_name" => "Retail Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.RC",
                "position_name" => "Concession Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.NL",
                "position_name" => "Food & Beverage, Lounge, & Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LR",
                "position_name" => "Food & Beverage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LU",
                "position_name" => "Lounge, Hotel & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.NS",
                "position_name" => "Advertising & Landside Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SV",
                "position_name" => "Advertising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SD",
                "position_name" => "Landside Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SG",
                "position_name" => "Parking Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.NV",
                "position_name" => "Fitting Out & Visual Merchandising Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VF",
                "position_name" => "Fitting Out Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VM",
                "position_name" => "Visual Merchandising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.PH",
                "position_name" => "Cargo & Property Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.HC",
                "position_name" => "Cargo Related Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.HP",
                "position_name" => "Property Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.AF",
                "position_name" => "Deputy General Manager Airport Facility, Equipment & Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.FE",
                "position_name" => "Assistant Deputy Airport Electrical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.EP",
                "position_name" => "Energy & Power Supply Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EH",
                "position_name" => "High & Medium Voltage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EM",
                "position_name" => "Main Power Station 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ES",
                "position_name" => "Main Power Station 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EA",
                "position_name" => "Main Power Station 3 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ET",
                "position_name" => "Electrical Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EN",
                "position_name" => "Electrical Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.EU",
                "position_name" => "Electrical Utility & Visual Aid Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.UU",
                "position_name" => "UPS & Converter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.UN",
                "position_name" => "North Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.US",
                "position_name" => "South Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.UE",
                "position_name" => "Electrical Utility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.TN",
                "position_name" => "Terminal & Non-Terminal Electrical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TX",
                "position_name" => "T1 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TR",
                "position_name" => "T2 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TZ",
                "position_name" => "T3 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PN",
                "position_name" => "Non-Terminal Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.AM",
                "position_name" => "Assistant Deputy Airport Mechanical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.MA",
                "position_name" => "Airport Mechanical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AC",
                "position_name" => "Sanitation Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AW",
                "position_name" => "Water Treatment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AG",
                "position_name" => "Ground Support System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.ME",
                "position_name" => "Airport Equipment Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EE",
                "position_name" => "Equipment & Workshop Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EF",
                "position_name" => "APMS Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EG",
                "position_name" => "Baggage Handling System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.TH",
                "position_name" => "Terminal & Non-Terminal Mechanical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.HX",
                "position_name" => "T1 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.HY",
                "position_name" => "T2 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.HZ",
                "position_name" => "T3 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LV",
                "position_name" => "T3 Ventilation & Air Conditioning Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.LN",
                "position_name" => "Non-Terminal Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.ES",
                "position_name" => "Assistant Deputy Airport Electronics Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SE",
                "position_name" => "Safety & Security Electronic Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EX",
                "position_name" => "T1 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EY",
                "position_name" => "T2 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.EZ",
                "position_name" => "T3 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SN",
                "position_name" => "Non-Terminal Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SD",
                "position_name" => "General Electronic Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DX",
                "position_name" => "T1 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DY",
                "position_name" => "T2 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DZ",
                "position_name" => "T3 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.DN",
                "position_name" => "Non-Terminal General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.ST",
                "position_name" => "Assistant Deputy Airport Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TY",
                "position_name" => "IT Public Service & Security System Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TB",
                "position_name" => "Public Service & IT System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TS",
                "position_name" => "Safety & Security IT Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TD",
                "position_name" => "Data Network & IT Non-Public Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TM",
                "position_name" => "Communication & Data Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TN",
                "position_name" => "IT Non-Public Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TO",
                "position_name" => "Control Center IT Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.DF",
                "position_name" => "Assistant Deputy Airside Facility & Support Services",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.FA",
                "position_name" => "Airside Infrastructure Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AR",
                "position_name" => "North Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AS",
                "position_name" => "South Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.AD",
                "position_name" => "Airfield Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.FS",
                "position_name" => "Accessibility & Environment Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SR",
                "position_name" => "Accessibility & Road Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SE",
                "position_name" => "Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SL",
                "position_name" => "Landscape Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.AB",
                "position_name" => "Assistant Deputy Airport Building Facility Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.BXY",
                "position_name" => "Terminal 1, 2 & Non-Terminal Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.XX",
                "position_name" => "Terminal 1 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.XY",
                "position_name" => "Terminal 2 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BN",
                "position_name" => "Non-Terminal Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.PZ",
                "position_name" => "Terminal 3 Building Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ZD",
                "position_name" => "Terminal 3 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ZI",
                "position_name" => "Terminal 3 Infrastructure Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.HB",
                "position_name" => "Deputy General Manager Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.BS",
                "position_name" => "Assistant Deputy Human Capital Solution & Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SP",
                "position_name" => "Human Capital Solution Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.ST",
                "position_name" => "Talent Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.PH",
                "position_name" => "Human Capital Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.ST",
                "position_name" => "Human Capital Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TV",
                "position_name" => "People Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TL",
                "position_name" => "Learning Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.GS",
                "position_name" => "Assistant Deputy General Services & CSR",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SG",
                "position_name" => "General Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.GA",
                "position_name" => "Office Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.GF",
                "position_name" => "Office Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SC",
                "position_name" => "Corporate Social Responsibility Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CC",
                "position_name" => "Community Engagement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CS",
                "position_name" => "Sustainability Initiative Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.PR",
                "position_name" => "Assistant Deputy Procurement",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.RS",
                "position_name" => "Operation & Services Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SA",
                "position_name" => "Airport Operation Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.SF",
                "position_name" => "Facility & Equipment Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.RB",
                "position_name" => "Business & Supporting Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BP",
                "position_name" => "Business Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BS",
                "position_name" => "Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.D.FR",
                "position_name" => "Deputy General Manager Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.RM",
                "position_name" => "Assistant Deputy Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.MF",
                "position_name" => "Finance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.FC",
                "position_name" => "Cash Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.FR",
                "position_name" => "Account Receivable Collection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.FA",
                "position_name" => "Receivable Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.MR",
                "position_name" => "Risk Management & Governance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.RT",
                "position_name" => "Risk Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.RG",
                "position_name" => "Governance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.AT",
                "position_name" => "Assistant Deputy Accounting & Tax",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.TB",
                "position_name" => "Account & Budgeting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BB",
                "position_name" => "Budgeting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BG",
                "position_name" => "General Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.BM",
                "position_name" => "Management Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.TT",
                "position_name" => "Tax Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TC",
                "position_name" => "Tax Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.TG",
                "position_name" => "Tax Reporting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.AS",
                "position_name" => "Assistant Deputy Asset Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.MC",
                "position_name" => "Asset Information Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CF",
                "position_name" => "Fixed Asset & Inventory Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CW",
                "position_name" => "Asset Write Off Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.MV",
                "position_name" => "Asset Evaluation & Readiness Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VL",
                "position_name" => "Land Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.VU",
                "position_name" => "Asset Utilization & Dispute Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.AO",
                "position_name" => "Assistant Deputy Airport Operation Control Center",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.OC",
                "position_name" => "Operation Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.OM",
                "position_name" => "Operation Maintenance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.CL",
                "position_name" => "Assistant Deputy Communication & Legal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V. LC",
                "position_name" => "Branch Communication Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CM",
                "position_name" => "Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.CT",
                "position_name" => "Secretariat & Internal Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.LG",
                "position_name" => "Legal Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.GL",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.P.GI",
                "position_name" => "Legal Aid & Institutional Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.CS",
                "position_name" => "Assistant Deputy Airport Customer Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SH",
                "position_name" => "Customer Handling Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.HX",
                "position_name" => "T1 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.HY",
                "position_name" => "T2 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.HZ",
                "position_name" => "T3 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.CN",
                "position_name" => "Non-Terminal Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.CI",
                "position_name" => "Cleanliness & Customer Improvement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.IS",
                "position_name" => "Cleanliness Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.II",
                "position_name" => "Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.A.QS",
                "position_name" => "Assistant Deputy Quality & Safety Management System",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SO",
                "position_name" => "Airport Operation Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SQ",
                "position_name" => "Airport Service Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SA",
                "position_name" => "Airport Maintenance Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.V.SS",
                "position_name" => "Safety Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.GM.X",
                "position_name" => "General Manager Terminal 1",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.XA",
                "position_name" => "T1 Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.XL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.XE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.XF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.XD",
                "position_name" => "T1 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.XL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.XE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.XF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.GM.Y",
                "position_name" => "General Manager Terminal 2",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.YA",
                "position_name" => "T2 Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.YL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.YE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.YF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.YD",
                "position_name" => "T2 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.YL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.YE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.YF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.GM.Z",
                "position_name" => "General Manager Terminal 3",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.ZI",
                "position_name" => "T3 International Departure Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.IL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.IL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.IL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.ZD",
                "position_name" => "T3 Domestic Departure Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.DL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.ZA",
                "position_name" => "T3 International & Domestic Arrival Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.AL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.H.ZC",
                "position_name" => "T3 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.CL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.CL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "unit_code" => "CGK.CL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "EGM.HLP",
                "position_name" => "Executive General Manager Operasional",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.SY",
                "position_name" => "Assistant Manager of Safety, Risk & Quality Control",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.SA",
                "position_name" => "Assistant Manager of Airside Operation & Landside Service",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.SS",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.SF",
                "position_name" => "Assistant Manager of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.ME",
                "position_name" => "Assistant Manager of Facility Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.MI",
                "position_name" => "Assistant Manager of Infrastructure & Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "HLP",
                "unit_code" => "HLP.S.IC",
                "position_name" => "Officer in Charge",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.GM",
                "position_name" => "General Manager KC Bandara Husein Sastranegara",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDO",
                "unit_code" => "BDO.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "EGM.KJT",
                "position_name" => "Executive General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.M.OS",
                "position_name" => "Manager of Operation & Service",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.SA",
                "position_name" => "Assistant Manager of Airport Operation & Service",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.SR",
                "position_name" => "Assistant Manager Of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.SS",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.M.AM",
                "position_name" => "Manager of Airport Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.ME",
                "position_name" => "Assistant Manager of Electronic Facility & IT",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.MM",
                "position_name" => "Assistant Manager of Electrical & Mechanical Facility",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.MI",
                "position_name" => "Assistant Manager of Infrastructure",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.M.FG",
                "position_name" => "Manager of Finance & General Affairs",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.GF",
                "position_name" => "Assistant Manager of Finance",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.GA",
                "position_name" => "Assistant Manager of General Affairs",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.SM",
                "position_name" => "Assistant Manager of Safety & Risk Management",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.QD",
                "position_name" => "Assistant Manager of Airport Quality & Data Management",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KJT",
                "unit_code" => "KJT.S.PL",
                "position_name" => "Assistant Manager of Procurement & Legal",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "CEO.DPR",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "DPR.D.ROS",
                "position_name" => "Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "DPR.D.RAC",
                "position_name" => "Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "DPR.D.RFT",
                "position_name" => "Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "DPR.D.RAM",
                "position_name" => "Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG II",
                "unit_code" => "DPR.D.RHB",
                "position_name" => "Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.GM",
                "position_name" => "General Manager KC Bandara Internasional I Gusti Ngurah Rai",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.D.AO",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.OA",
                "position_name" => "Airport Airside & ARFF Operation Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.AS",
                "position_name" => "Airside Operation Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.AA",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.OS",
                "position_name" => "Airport Security Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.ST",
                "position_name" => "Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SV",
                "position_name" => "Screening & Surveillance Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.OL",
                "position_name" => "Landside Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.LT",
                "position_name" => "Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.LN",
                "position_name" => "Non Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.D.AC",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.CA",
                "position_name" => "Aero Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.AI",
                "position_name" => "Domestic Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.AD",
                "position_name" => "International Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.CN",
                "position_name" => "Non-Aero Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.NR",
                "position_name" => "Retail And Concession Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.NF",
                "position_name" => "F&B, Lounge, And Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.NA",
                "position_name" => "Advertising And Landside Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.NV",
                "position_name" => "Fitting Out & Visual Merchandise Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.NC",
                "position_name" => "Cargo & Property Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.D.AF",
                "position_name" => "Deputy General Manager Airport Facility & Equipment Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.FE",
                "position_name" => "Airport Equipment Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.EM",
                "position_name" => "Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.ES",
                "position_name" => "Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.ET",
                "position_name" => "Electronics & Technology Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.FS",
                "position_name" => "Airport Facility Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SA",
                "position_name" => "Airside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SL",
                "position_name" => "Landside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SF",
                "position_name" => "Terminal Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.D.FH",
                "position_name" => "Deputy General Manager Finance, Hc & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.HH",
                "position_name" => "Human Capital, GS, & CSR Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.HC",
                "position_name" => "Human Capital Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.HD",
                "position_name" => "Human Capital Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.HG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.HS",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.HP",
                "position_name" => "Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.PO",
                "position_name" => "Operation & Services Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.PB",
                "position_name" => "Business & Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.HF",
                "position_name" => "Finance, Risk, Accounting, Tax & Asset Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.FA",
                "position_name" => "Asset Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.FR",
                "position_name" => "Finance & Risk Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.FT",
                "position_name" => "Accounting & Tax Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.OC",
                "position_name" => "Airport Operation Control Centre Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.CC",
                "position_name" => "Operation Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.CN",
                "position_name" => "Operation Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.CL",
                "position_name" => "Branch Communication & Legal Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.CM",
                "position_name" => "Branch Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.LG",
                "position_name" => "Legal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.CS",
                "position_name" => "Airport Customer Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SH",
                "position_name" => "Customer Handling & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SI",
                "position_name" => "Cleanliness & Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.V.QS",
                "position_name" => "Quality & Safety Management System Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SP",
                "position_name" => "Airport Operation Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SY",
                "position_name" => "Airport Service Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.SQ",
                "position_name" => "Airport Maintenance Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.P.QS",
                "position_name" => "Safety Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "GMT.DPS",
                "position_name" => "General Manager Terminal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.H.ID",
                "position_name" => "Terminal International Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.H.IA",
                "position_name" => "Terminal International Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.H.DD",
                "position_name" => "Terminal Domestic Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DPS",
                "unit_code" => "DPS.H.DA",
                "position_name" => "Terminal Domestic Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.GM",
                "position_name" => "General Manager KC Bandara Internasional Zainuddin Abdul Madjid",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.V.AF",
                "position_name" => "Airport Safety, Risk and Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.FM",
                "position_name" => "Safety Management System & Ohs Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.OL",
                "position_name" => "Airport Operation Land Side, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "LOP",
                "unit_code" => "LOP.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.OS",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.OF",
                "position_name" => "Airport Facilities, Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "KOE",
                "unit_code" => "KOE.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.P.OG",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.P.OI",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BWX",
                "unit_code" => "BWX.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.D.AOS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "",
                "position_name" => "Airport Operation & Service Quality Assurance",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "",
                "position_name" => "Airport Operation & Service Improvement",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.D.ACM",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "",
                "position_name" => "Airport Connectivity",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "",
                "position_name" => "Commercial Assurance",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.D.AFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.D.FAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG III",
                "unit_code" => "KNR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.GM",
                "position_name" => "General Manager KC Bandara Internasional Sultan Iskandar Muda",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.AF",
                "position_name" => "Airport Safety, Risk and Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "unit_code" => "BTJ.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PDG",
                "unit_code" => "PDG.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.OF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.OQ",
                "position_name" => "Airport Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DTB",
                "unit_code" => "DTB.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJB",
                "unit_code" => "DJB.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKU",
                "unit_code" => "PKU.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PLM",
                "unit_code" => "PLM.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PGK",
                "unit_code" => "PGK.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.P.FT",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.P.AC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TKG",
                "unit_code" => "TKG.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.P.OG",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.P.OI",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TNJ",
                "unit_code" => "TNJ.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "TJQ",
                "unit_code" => "TJQ.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.P.FT",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.P.AC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BKS",
                "unit_code" => "BKS.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG IV",
                "unit_code" => "YIR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OL",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "unit_code" => "YIA.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AO",
                "position_name" => "Airport Operation & Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.OL",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AS",
                "position_name" => "Airport Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.SP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.SS",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.CX",
                "position_name" => "Airport Non Aeronautical Terminal 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.CY",
                "position_name" => "Airport Non Aeronautical Terminal 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SUB",
                "unit_code" => "SUB.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SRG",
                "unit_code" => "SRG.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.P.AO",
                "position_name" => "Airport Operation, Service, Security & Arff Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.P.AF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.P.AC",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.P.AP",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "JOG",
                "unit_code" => "JOG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.LS",
                "position_name" => "Legal, Compliance, & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.V.AO",
                "position_name" => "Airport Operation, Services, Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.OL",
                "position_name" => "Airport Operation Landside & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "SOC",
                "unit_code" => "SOC.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PWL",
                "unit_code" => "PWL.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PWL",
                "unit_code" => "PWL.C.OS",
                "position_name" => "Airport Operation, Services & Security Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PWL",
                "unit_code" => "PWL.C.AT",
                "position_name" => "Airport Technical  Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PWL",
                "unit_code" => "PWL.C.AA",
                "position_name" => "Airport Administration Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.LC",
                "position_name" => "Legal, Compliance, and Stakeholder Relation Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.AF",
                "position_name" => "Airport Safety, Risk, and Performance Management Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.PR",
                "position_name" => "Procurement Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.R.AO",
                "position_name" => "Airport Operation, Services, Security, and Technical Senior Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.OS",
                "position_name" => "Airport Operation and Service Improvement Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.OR",
                "position_name" => "Airport Rescue, Fire Fighting, and Security Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.TF",
                "position_name" => "Airport Facilities Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.TE",
                "position_name" => "Airport Equipment Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.TI",
                "position_name" => "Airport Technology Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.R.AD",
                "position_name" => "Airport Commercial and Administration Senior Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.DC",
                "position_name" => "Airport Commercial Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.DF",
                "position_name" => "Finance Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DHX",
                "unit_code" => "DHX.M.DH",
                "position_name" => "Human Capital Business Partner and General Services Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG V",
                "unit_code" => "UPR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OL",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "unit_code" => "UPG.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.OL",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.OF",
                "position_name" => "Airport Facilities, Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "AMQ",
                "unit_code" => "AMQ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "MDC",
                "unit_code" => "MDC.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.P.AO",
                "position_name" => "Airport Operation, Service, Security & Safety Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.P.AF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.P.AC",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BIK",
                "unit_code" => "BIK.P.AP",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal, & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CR",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CO",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CN",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CB",
                "position_name" => "Cargo & Business Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DJJ",
                "unit_code" => "DJJ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "",
                "position_name" => "Airport Operation & Services Quality Assurance & Improvement",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "REG VI",
                "unit_code" => "BPR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OL",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "unit_code" => "BPN.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PNK",
                "unit_code" => "PNK.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BDJ",
                "unit_code" => "BDJ.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "PKY",
                "unit_code" => "PKY.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ]
        ];

        foreach ($positions as $position) {
            Position::where('personnel_area_code', $position['personnel_area_code'])
                ->where('unit_code_doc', $position['unit_code'])
                ->update([
                    'assigned_roles' => $position['assigned_roles']
                ]);
        }
    }
}
