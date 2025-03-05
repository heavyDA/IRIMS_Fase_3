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
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DU",
                "position_name" => "Direktur Utama",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DUS",
                "position_name" => "Corporate Secretary Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "USC",
                "position_name" => "Corporate Communication Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "USB",
                "position_name" => "Corporate Branding Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "USS",
                "position_name" => "Corporate BOD Office Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DUI",
                "position_name" => "Internal Audit Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UIO",
                "position_name" => "Operational Audit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UIB",
                "position_name" => "Business & Supporting Audit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UIS",
                "position_name" => "Special Audit & Advisory Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DUC",
                "position_name" => "Legal & Compliance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UCB",
                "position_name" => "Legal Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UCR",
                "position_name" => "Regulation & Compliance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DUL",
                "position_name" => "Legal Aid & Institutional Relation Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ULA",
                "position_name" => "Legal Aid Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ULI",
                "position_name" => "Institutional Relation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DUE",
                "position_name" => "Customer Experience Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UEE",
                "position_name" => "Customer Experience Design & Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UEI",
                "position_name" => "Customer Insight & Quality Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "UEA",
                "position_name" => "Airport Service Delivery Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DSS",
                "position_name" => "Corporate Strategy & Performance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SSS",
                "position_name" => "Corporate Strategy & Planning Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SSR",
                "position_name" => "Corporate Performance & Research Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SCT",
                "position_name" => "Corporate Transformation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DSB",
                "position_name" => "Business Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SBB",
                "position_name" => "Business Development & Asset Optimization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SBS",
                "position_name" => "Strategic Partnership Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DSA",
                "position_name" => "Asset Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SAA",
                "position_name" => "Asset Evaluation & Readiness Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "SAI",
                "position_name" => "Asset Information Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DST",
                "position_name" => "Technology & Digitalization Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "STE",
                "position_name" => "Enterprise Application Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "STA",
                "position_name" => "Airport Application Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "STI",
                "position_name" => "IT Infrastructure & Network Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "STC",
                "position_name" => "Cyber Security, Business Intelligence & Analytics Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DCC",
                "position_name" => "Commercial Strategy & Policy Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CCA",
                "position_name" => "Aero Commercial Strategy & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CCN",
                "position_name" => "Non-Aero Commercial Strategy & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DCA",
                "position_name" => "Aero Commercial Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CAD",
                "position_name" => "Domestic-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CAA",
                "position_name" => "Asia Pacific-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CAE",
                "position_name" => "EMEA-Airline Partnership & Route Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DCN",
                "position_name" => "Non-Aero Commercial Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNM",
                "position_name" => "Marketing & Promotion Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNR",
                "position_name" => "Retail Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNT",
                "position_name" => "Tenant Relation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNV",
                "position_name" => "Visual Merchandise Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNF",
                "position_name" => "Fitting Out Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "CNC",
                "position_name" => "Cargo & Property Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DOP",
                "position_name" => "Airport Operation Strategy & Policy Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OPP",
                "position_name" => "Airport Operation Planning & Policy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OPD",
                "position_name" => "Airport Operation Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OPL",
                "position_name" => "Airside & Landside Operation Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OPS",
                "position_name" => "Airside & Landside Operation Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DOS",
                "position_name" => "Airport Safety Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OSA",
                "position_name" => "Airport Safety Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OSS",
                "position_name" => "Airport Safety Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DOA",
                "position_name" => "Airport Security Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OAA",
                "position_name" => "Airport Security Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "OAS",
                "position_name" => "Airport Security Standardization Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DTE",
                "position_name" => "Airport Engineering Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TED",
                "position_name" => "Airport Engineering & Design Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TEM",
                "position_name" => "Airport Environmental Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DTF",
                "position_name" => "Airport Facility Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TFC",
                "position_name" => "Civil Airside Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TFT",
                "position_name" => "Terminal Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TFN",
                "position_name" => "Non-Terminal & Landscape Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DTM",
                "position_name" => "Airport Equipment Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TMM",
                "position_name" => "Mechanical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TME",
                "position_name" => "Electrical Divison Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TMC",
                "position_name" => "Electronic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DTA",
                "position_name" => "Airport Costruction & Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "TAA",
                "position_name" => "Airport Construction & Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DKF",
                "position_name" => "Corporate Finance Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KFT",
                "position_name" => "Treasury Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KFF",
                "position_name" => "Capital Financing Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KFM",
                "position_name" => "Capital Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DKR",
                "position_name" => "Financial Controller & Reporting Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KRB",
                "position_name" => "Business Planning & Analysis Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KRS",
                "position_name" => "Strategic Management Report Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KRF",
                "position_name" => "Financial Accounting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "KRT",
                "position_name" => "Tax Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DMR",
                "position_name" => "Governance & Risk Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "MRG",
                "position_name" => "Governance Assurance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "MRE",
                "position_name" => "Enterprise Risk Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DHO",
                "position_name" => "Organization Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HOO",
                "position_name" => "Organization Strategy Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HOP",
                "position_name" => "Performance & Industrial Relations Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HOC",
                "position_name" => "Culture & Innovation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DHH",
                "position_name" => "Human Capital Management Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HHT",
                "position_name" => "Talent Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HHS",
                "position_name" => "Human Capital Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DHL",
                "position_name" => "Learning & Development Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HLD",
                "position_name" => "People Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HLL",
                "position_name" => "Learning Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DHP",
                "position_name" => "Procurement & Logistic Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HPP",
                "position_name" => "Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HPL",
                "position_name" => "Logistic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DHC",
                "position_name" => "Corporate Social Responsibility & General Service Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HCC",
                "position_name" => "Corporate Social Responsibility Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HCE",
                "position_name" => "Environmental, Social & Governance Performance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HCF",
                "position_name" => "Office Facilities Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "HCA",
                "position_name" => "Office Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA",
                "position_name" => "Head of Airport Construction Area A",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.PC",
                "position_name" => "Project Construction Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.PM",
                "position_name" => "Project Monitoring & Evaluation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.XP",
                "position_name" => "CGK 1 Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.YP",
                "position_name" => "CGK 2 Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.PI",
                "position_name" => "SUB & SRG Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.PN",
                "position_name" => "PGK, TKG, TJQ & BKS Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADA.V.PT",
                "position_name" => "PDG & PKU Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB",
                "position_name" => "Head of Airport Construction Area B",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PC",
                "position_name" => "Project Construction Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PM",
                "position_name" => "Project Monitoring & Evaluation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PI",
                "position_name" => "DPS Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PN",
                "position_name" => "DJJ Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PT",
                "position_name" => "UPG Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADB.V.PE",
                "position_name" => "PNK, PKY, BPN & BDJ Project Implementation Unit Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADE",
                "position_name" => "Head of Project Engineering",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADE.V.PB",
                "position_name" => "Project Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADE.V.PF",
                "position_name" => "Project Infrastructure Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADE.V.PE",
                "position_name" => "Project Mechanical, Electrical & Electronic Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADF",
                "position_name" => "Head of Project Finance & General Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADF.V.PA",
                "position_name" => "Project Accounting & Budgeting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADF.V.PG",
                "position_name" => "Project General Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADF.V.PS",
                "position_name" => "Project Treasury Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADP",
                "position_name" => "Head of Project Procurement & Legal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADP.V.PP",
                "position_name" => "Project Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADP.V.PL",
                "position_name" => "Project Legal & Contract Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "DSC",
                "position_name" => "Corporate Transformation Group Head",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DU",
                "position_name" => "Lead Transformation Office Direktorat Utama",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DS",
                "position_name" => "Lead Transformation Office Direktorat Strategi & Pengembangan Teknologi",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DK",
                "position_name" => "Lead Transformation Office Direktorat Komersial",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DO",
                "position_name" => "Lead Transformation Office Direktorat Operasi",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DT",
                "position_name" => "Lead Transformation Office Direktorat Teknik",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DM",
                "position_name" => "Lead Transformation Office Direktorat Keuangan & Manajemen Risiko",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADT.DH",
                "position_name" => "Lead Transformation Office Direktorat Human Capital",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADS",
                "position_name" => "Head of Shared Service Center",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADS.V.TAR",
                "position_name" => "Treasury & Account Receivable Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADS.V.BAS",
                "position_name" => "Budgeting & Accounting Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADS.V.OSP",
                "position_name" => "Operation & Services Procurement Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADS.V.BSP",
                "position_name" => "Business & Supporting Procurement Shared Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR",
                "position_name" => "Head of Enterprise Resource Planning Project",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.PMA",
                "position_name" => "Project Monitoring & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.TIN",
                "position_name" => "Technology & Integration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.HCR",
                "position_name" => "Human Capital Management Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.FAR",
                "position_name" => "Financial Accounting Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.CRR",
                "position_name" => "Commercial & REM Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.AMR",
                "position_name" => "Asset & Material Management Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PST",
                "sub_unit_code_doc" => "ADR.V.FER",
                "position_name" => "Facility & Equipment Maintenance Business Process Reengineering Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG I",
                "sub_unit_code_doc" => "CGR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.AO",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.OO",
                "position_name" => "Assistant Deputy Airside Operation Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.OX",
                "position_name" => "T1 & Cargo Airside Operation Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AX",
                "position_name" => "T1 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.OC",
                "position_name" => "Cargo Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.OV",
                "position_name" => "T2 & T3 Airside Operation Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VY",
                "position_name" => "T2 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VZ",
                "position_name" => "T3 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.RF",
                "position_name" => "Assistant Deputy Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.FP",
                "position_name" => "Airport Rescue & Fire Fighting Operations Performance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PA",
                "position_name" => "Aircraft Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PR",
                "position_name" => "Building Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.FM",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance & Prevention Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.MM",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ME",
                "position_name" => "Airport Rescue & Fire Fighting Exercise & Prevention Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.SP",
                "position_name" => "Assistant Deputy Airport Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SL",
                "position_name" => "Screening & Surveillances Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LX",
                "position_name" => "T1 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LY",
                "position_name" => "T2 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LZ",
                "position_name" => "T3 Domestic Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.IZ",
                "position_name" => "T3 International Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LT",
                "position_name" => "CCTV Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.PP",
                "position_name" => "Protection Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.PV",
                "position_name" => "Perimeter & Vital Object Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PO",
                "position_name" => "Non-Terminal & Traffic Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PD",
                "position_name" => "Cargo Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PS",
                "position_name" => "T1 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PC",
                "position_name" => "T2 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PT",
                "position_name" => "T3 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.LP",
                "position_name" => "Assistant Deputy Landside Operation Services & Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.PL",
                "position_name" => "Landside & Cargo Operation Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LL",
                "position_name" => "Landside Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LO",
                "position_name" => "Cargo Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LD",
                "position_name" => "TOD Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.PT",
                "position_name" => "Public Transportation Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TA",
                "position_name" => "APMS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TI",
                "position_name" => "Mass Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TP",
                "position_name" => "Personal Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SXY",
                "position_name" => "T1 & T2 Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SX",
                "position_name" => "T1 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SY",
                "position_name" => "T2 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.EZ",
                "position_name" => "T3 Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ED",
                "position_name" => "T3 Domestic Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EI",
                "position_name" => "T3 International Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.AC",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.CA",
                "position_name" => "Assistant Deputy Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.AI",
                "position_name" => "International Aero Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.IP",
                "position_name" => "International PJP4U, PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.IS",
                "position_name" => "International Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.IC",
                "position_name" => "International PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.AD",
                "position_name" => "Domestic Aero Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DD",
                "position_name" => "Domestic PJP4U, PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DS",
                "position_name" => "Domestic Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DP",
                "position_name" => "Domestic PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.DN",
                "position_name" => "Assistant Deputy Non-Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.NR",
                "position_name" => "Retail & Concession Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.RR",
                "position_name" => "Retail Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.RC",
                "position_name" => "Concession Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.NL",
                "position_name" => "Food & Beverage, Lounge, & Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LR",
                "position_name" => "Food & Beverage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LU",
                "position_name" => "Lounge, Hotel & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.NS",
                "position_name" => "Advertising & Landside Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SV",
                "position_name" => "Advertising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SD",
                "position_name" => "Landside Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SG",
                "position_name" => "Parking Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.NV",
                "position_name" => "Fitting Out & Visual Merchandising Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VF",
                "position_name" => "Fitting Out Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VM",
                "position_name" => "Visual Merchandising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.PH",
                "position_name" => "Cargo & Property Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.HC",
                "position_name" => "Cargo Related Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.HP",
                "position_name" => "Property Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.AF",
                "position_name" => "Deputy General Manager Airport Facility, Equipment & Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.FE",
                "position_name" => "Assistant Deputy Airport Electrical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.EP",
                "position_name" => "Energy & Power Supply Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EH",
                "position_name" => "High & Medium Voltage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EM",
                "position_name" => "Main Power Station 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ES",
                "position_name" => "Main Power Station 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EA",
                "position_name" => "Main Power Station 3 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ET",
                "position_name" => "Electrical Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EN",
                "position_name" => "Electrical Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.EU",
                "position_name" => "Electrical Utility & Visual Aid Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.UU",
                "position_name" => "UPS & Converter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.UN",
                "position_name" => "North Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.US",
                "position_name" => "South Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.UE",
                "position_name" => "Electrical Utility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.TN",
                "position_name" => "Terminal & Non-Terminal Electrical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TX",
                "position_name" => "T1 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TR",
                "position_name" => "T2 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TZ",
                "position_name" => "T3 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PN",
                "position_name" => "Non-Terminal Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.AM",
                "position_name" => "Assistant Deputy Airport Mechanical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.MA",
                "position_name" => "Airport Mechanical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AC",
                "position_name" => "Sanitation Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AW",
                "position_name" => "Water Treatment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AG",
                "position_name" => "Ground Support System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.ME",
                "position_name" => "Airport Equipment Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EE",
                "position_name" => "Equipment & Workshop Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EF",
                "position_name" => "APMS Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EG",
                "position_name" => "Baggage Handling System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.TH",
                "position_name" => "Terminal & Non-Terminal Mechanical Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.HX",
                "position_name" => "T1 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.HY",
                "position_name" => "T2 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.HZ",
                "position_name" => "T3 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LV",
                "position_name" => "T3 Ventilation & Air Conditioning Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.LN",
                "position_name" => "Non-Terminal Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.ES",
                "position_name" => "Assistant Deputy Airport Electronics Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SE",
                "position_name" => "Safety & Security Electronic Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EX",
                "position_name" => "T1 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EY",
                "position_name" => "T2 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.EZ",
                "position_name" => "T3 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SN",
                "position_name" => "Non-Terminal Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SD",
                "position_name" => "General Electronic Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DX",
                "position_name" => "T1 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DY",
                "position_name" => "T2 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DZ",
                "position_name" => "T3 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.DN",
                "position_name" => "Non-Terminal General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.ST",
                "position_name" => "Assistant Deputy Airport Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TY",
                "position_name" => "IT Public Service & Security System Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TB",
                "position_name" => "Public Service & IT System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TS",
                "position_name" => "Safety & Security IT Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TD",
                "position_name" => "Data Network & IT Non-Public Service Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TM",
                "position_name" => "Communication & Data Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TN",
                "position_name" => "IT Non-Public Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TO",
                "position_name" => "Control Center IT Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.DF",
                "position_name" => "Assistant Deputy Airside Facility & Support Services",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.FA",
                "position_name" => "Airside Infrastructure Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AR",
                "position_name" => "North Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AS",
                "position_name" => "South Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.AD",
                "position_name" => "Airfield Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.FS",
                "position_name" => "Accessibility & Environment Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SR",
                "position_name" => "Accessibility & Road Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SE",
                "position_name" => "Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SL",
                "position_name" => "Landscape Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.AB",
                "position_name" => "Assistant Deputy Airport Building Facility Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.BXY",
                "position_name" => "Terminal 1, 2 & Non-Terminal Building Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.XX",
                "position_name" => "Terminal 1 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.XY",
                "position_name" => "Terminal 2 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BN",
                "position_name" => "Non-Terminal Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.PZ",
                "position_name" => "Terminal 3 Building Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ZD",
                "position_name" => "Terminal 3 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ZI",
                "position_name" => "Terminal 3 Infrastructure Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.HB",
                "position_name" => "Deputy General Manager Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.BS",
                "position_name" => "Assistant Deputy Human Capital Solution & Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SP",
                "position_name" => "Human Capital Solution Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.ST",
                "position_name" => "Talent Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.PH",
                "position_name" => "Human Capital Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.ST",
                "position_name" => "Human Capital Development Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TV",
                "position_name" => "People Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TL",
                "position_name" => "Learning Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.GS",
                "position_name" => "Assistant Deputy General Services & CSR",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SG",
                "position_name" => "General Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.GA",
                "position_name" => "Office Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.GF",
                "position_name" => "Office Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SC",
                "position_name" => "Corporate Social Responsibility Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CC",
                "position_name" => "Community Engagement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CS",
                "position_name" => "Sustainability Initiative Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.PR",
                "position_name" => "Assistant Deputy Procurement",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.RS",
                "position_name" => "Operation & Services Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SA",
                "position_name" => "Airport Operation Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.SF",
                "position_name" => "Facility & Equipment Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.RB",
                "position_name" => "Business & Supporting Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BP",
                "position_name" => "Business Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BS",
                "position_name" => "Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.D.FR",
                "position_name" => "Deputy General Manager Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.RM",
                "position_name" => "Assistant Deputy Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.MF",
                "position_name" => "Finance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.FC",
                "position_name" => "Cash Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.FR",
                "position_name" => "Account Receivable Collection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.FA",
                "position_name" => "Receivable Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.MR",
                "position_name" => "Risk Management & Governance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.RT",
                "position_name" => "Risk Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.RG",
                "position_name" => "Governance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.AT",
                "position_name" => "Assistant Deputy Accounting & Tax",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.TB",
                "position_name" => "Account & Budgeting Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BB",
                "position_name" => "Budgeting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BG",
                "position_name" => "General Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.BM",
                "position_name" => "Management Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.TT",
                "position_name" => "Tax Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TC",
                "position_name" => "Tax Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.TG",
                "position_name" => "Tax Reporting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.AS",
                "position_name" => "Assistant Deputy Asset Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.MC",
                "position_name" => "Asset Information Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CF",
                "position_name" => "Fixed Asset & Inventory Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CW",
                "position_name" => "Asset Write Off Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.MV",
                "position_name" => "Asset Evaluation & Readiness Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VL",
                "position_name" => "Land Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.VU",
                "position_name" => "Asset Utilization & Dispute Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.AO",
                "position_name" => "Assistant Deputy Airport Operation Control Center",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.OC",
                "position_name" => "Operation Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.OM",
                "position_name" => "Operation Maintenance Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.CL",
                "position_name" => "Assistant Deputy Communication & Legal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V. LC",
                "position_name" => "Branch Communication Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CM",
                "position_name" => "Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.CT",
                "position_name" => "Secretariat & Internal Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.LG",
                "position_name" => "Legal Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.GL",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.P.GI",
                "position_name" => "Legal Aid & Institutional Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.CS",
                "position_name" => "Assistant Deputy Airport Customer Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SH",
                "position_name" => "Customer Handling Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.HX",
                "position_name" => "T1 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.HY",
                "position_name" => "T2 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.HZ",
                "position_name" => "T3 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.CN",
                "position_name" => "Non-Terminal Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.CI",
                "position_name" => "Cleanliness & Customer Improvement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.IS",
                "position_name" => "Cleanliness Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.II",
                "position_name" => "Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.A.QS",
                "position_name" => "Assistant Deputy Quality & Safety Management System",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SO",
                "position_name" => "Airport Operation Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SQ",
                "position_name" => "Airport Service Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SA",
                "position_name" => "Airport Maintenance Quality Control Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.V.SS",
                "position_name" => "Safety Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.GM.X",
                "position_name" => "General Manager Terminal 1",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.XA",
                "position_name" => "T1 Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.XL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.XE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.XF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.XD",
                "position_name" => "T1 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.XL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.XE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.XF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.GM.Y",
                "position_name" => "General Manager Terminal 2",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.YA",
                "position_name" => "T2 Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.YL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.YE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.YF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.YD",
                "position_name" => "T2 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.YL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.YE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.YF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.GM.Z",
                "position_name" => "General Manager Terminal 3",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.ZI",
                "position_name" => "T3 International Departure Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.IL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.IL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.IL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.ZD",
                "position_name" => "T3 Domestic Departure Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.DL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.ZA",
                "position_name" => "T3 International & Domestic Arrival Operation & Services Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.AL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.H.ZC",
                "position_name" => "T3 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.CL.ZL",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.CL.ZE",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "CGK",
                "sub_unit_code_doc" => "CGK.CL.ZF",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "EGM.HLP",
                "position_name" => "Executive General Manager Operasional",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.SY",
                "position_name" => "Assistant Manager of Safety, Risk & Quality Control",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.SA",
                "position_name" => "Assistant Manager of Airside Operation & Landside Service",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.SS",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.SF",
                "position_name" => "Assistant Manager of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.ME",
                "position_name" => "Assistant Manager of Facility Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.MI",
                "position_name" => "Assistant Manager of Infrastructure & Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "HLP",
                "sub_unit_code_doc" => "HLP.S.IC",
                "position_name" => "Officer in Charge",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.GM",
                "position_name" => "General Manager KC Bandara Husein Sastranegara",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDO",
                "sub_unit_code_doc" => "BDO.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "EGM.KJT",
                "position_name" => "Executive General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.M.OS",
                "position_name" => "Manager of Operation & Service",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.SA",
                "position_name" => "Assistant Manager of Airport Operation & Service",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.SR",
                "position_name" => "Assistant Manager Of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.SS",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.M.AM",
                "position_name" => "Manager of Airport Maintenance",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.ME",
                "position_name" => "Assistant Manager of Electronic Facility & IT",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.MM",
                "position_name" => "Assistant Manager of Electrical & Mechanical Facility",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.MI",
                "position_name" => "Assistant Manager of Infrastructure",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.M.FG",
                "position_name" => "Manager of Finance & General Affairs",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.GF",
                "position_name" => "Assistant Manager of Finance",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.GA",
                "position_name" => "Assistant Manager of General Affairs",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.SM",
                "position_name" => "Assistant Manager of Safety & Risk Management",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.QD",
                "position_name" => "Assistant Manager of Airport Quality & Data Management",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KJT",
                "sub_unit_code_doc" => "KJT.S.PL",
                "position_name" => "Assistant Manager of Procurement & Legal",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "CEO.DPR",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "DPR.D.ROS",
                "position_name" => "Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "DPR.D.RAC",
                "position_name" => "Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "DPR.D.RFT",
                "position_name" => "Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "DPR.D.RAM",
                "position_name" => "Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG II",
                "sub_unit_code_doc" => "DPR.D.RHB",
                "position_name" => "Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.GM",
                "position_name" => "General Manager KC Bandara Internasional I Gusti Ngurah Rai",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.D.AO",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.OA",
                "position_name" => "Airport Airside & ARFF Operation Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.AS",
                "position_name" => "Airside Operation Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.AA",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.OS",
                "position_name" => "Airport Security Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.ST",
                "position_name" => "Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SV",
                "position_name" => "Screening & Surveillance Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.OL",
                "position_name" => "Landside Services Support Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.LT",
                "position_name" => "Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.LN",
                "position_name" => "Non Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.D.AC",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.CA",
                "position_name" => "Aero Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.AI",
                "position_name" => "Domestic Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.AD",
                "position_name" => "International Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.CN",
                "position_name" => "Non-Aero Business Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.NR",
                "position_name" => "Retail And Concession Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.NF",
                "position_name" => "F&B, Lounge, And Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.NA",
                "position_name" => "Advertising And Landside Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.NV",
                "position_name" => "Fitting Out & Visual Merchandise Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.NC",
                "position_name" => "Cargo & Property Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.D.AF",
                "position_name" => "Deputy General Manager Airport Facility & Equipment Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.FE",
                "position_name" => "Airport Equipment Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.EM",
                "position_name" => "Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.ES",
                "position_name" => "Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.ET",
                "position_name" => "Electronics & Technology Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.FS",
                "position_name" => "Airport Facility Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SA",
                "position_name" => "Airside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SL",
                "position_name" => "Landside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SF",
                "position_name" => "Terminal Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.D.FH",
                "position_name" => "Deputy General Manager Finance, Hc & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.HH",
                "position_name" => "Human Capital, GS, & CSR Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.HC",
                "position_name" => "Human Capital Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.HD",
                "position_name" => "Human Capital Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.HG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.HS",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.HP",
                "position_name" => "Procurement Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.PO",
                "position_name" => "Operation & Services Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.PB",
                "position_name" => "Business & Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.HF",
                "position_name" => "Finance, Risk, Accounting, Tax & Asset Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.FA",
                "position_name" => "Asset Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.FR",
                "position_name" => "Finance & Risk Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.FT",
                "position_name" => "Accounting & Tax Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.OC",
                "position_name" => "Airport Operation Control Centre Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.CC",
                "position_name" => "Operation Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.CN",
                "position_name" => "Operation Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.CL",
                "position_name" => "Branch Communication & Legal Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.CM",
                "position_name" => "Branch Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.LG",
                "position_name" => "Legal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.CS",
                "position_name" => "Airport Customer Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SH",
                "position_name" => "Customer Handling & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SI",
                "position_name" => "Cleanliness & Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.V.QS",
                "position_name" => "Quality & Safety Management System Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SP",
                "position_name" => "Airport Operation Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SY",
                "position_name" => "Airport Service Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.SQ",
                "position_name" => "Airport Maintenance Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.P.QS",
                "position_name" => "Safety Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "GMT.DPS",
                "position_name" => "General Manager Terminal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.H.ID",
                "position_name" => "Terminal International Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.H.IA",
                "position_name" => "Terminal International Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.H.DD",
                "position_name" => "Terminal Domestic Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DPS",
                "sub_unit_code_doc" => "DPS.H.DA",
                "position_name" => "Terminal Domestic Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.GM",
                "position_name" => "General Manager KC Bandara Internasional Zainuddin Abdul Madjid",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.V.AF",
                "position_name" => "Airport Safety, Risk and Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.FM",
                "position_name" => "Safety Management System & Ohs Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.OL",
                "position_name" => "Airport Operation Land Side, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "LOP",
                "sub_unit_code_doc" => "LOP.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.OS",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.OF",
                "position_name" => "Airport Facilities, Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "KOE",
                "sub_unit_code_doc" => "KOE.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.P.OG",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.P.OI",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BWX",
                "sub_unit_code_doc" => "BWX.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.D.AOS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "",
                "position_name" => "Airport Operation & Service Quality Assurance",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "",
                "position_name" => "Airport Operation & Service Improvement",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.D.ACM",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "",
                "position_name" => "Airport Connectivity",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "",
                "position_name" => "Commercial Assurance",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.D.AFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.D.FAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG III",
                "sub_unit_code_doc" => "KNR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.GM",
                "position_name" => "General Manager KC Bandara Internasional Sultan Iskandar Muda",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.AF",
                "position_name" => "Airport Safety, Risk and Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BTJ",
                "sub_unit_code_doc" => "BTJ.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PDG",
                "sub_unit_code_doc" => "PDG.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.OF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.OQ",
                "position_name" => "Airport Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DTB",
                "sub_unit_code_doc" => "DTB.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJB",
                "sub_unit_code_doc" => "DJB.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKU",
                "sub_unit_code_doc" => "PKU.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PLM",
                "sub_unit_code_doc" => "PLM.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PGK",
                "sub_unit_code_doc" => "PGK.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.P.FT",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.P.AC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TKG",
                "sub_unit_code_doc" => "TKG.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.P.OG",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.P.OI",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TNJ",
                "sub_unit_code_doc" => "TNJ.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.P.TF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "TJQ",
                "sub_unit_code_doc" => "TJQ.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.P.OV",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.P.OF",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.P.FT",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.P.AC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BKS",
                "sub_unit_code_doc" => "BKS.P.AA",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG IV",
                "sub_unit_code_doc" => "YIR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OL",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "YIA",
                "sub_unit_code_doc" => "YIA.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AO",
                "position_name" => "Airport Operation & Services Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.OL",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AS",
                "position_name" => "Airport Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.SP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.SS",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.CX",
                "position_name" => "Airport Non Aeronautical Terminal 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.CY",
                "position_name" => "Airport Non Aeronautical Terminal 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SUB",
                "sub_unit_code_doc" => "SUB.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SRG",
                "sub_unit_code_doc" => "SRG.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.P.AO",
                "position_name" => "Airport Operation, Service, Security & Arff Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.P.AF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.P.AC",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.P.AP",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "JOG",
                "sub_unit_code_doc" => "JOG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.LS",
                "position_name" => "Legal, Compliance, & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.V.AO",
                "position_name" => "Airport Operation, Services, Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.OL",
                "position_name" => "Airport Operation Landside & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "SOC",
                "sub_unit_code_doc" => "SOC.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PWL",
                "sub_unit_code_doc" => "PWL.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PWL",
                "sub_unit_code_doc" => "PWL.C.OS",
                "position_name" => "Airport Operation, Services & Security Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PWL",
                "sub_unit_code_doc" => "PWL.C.AT",
                "position_name" => "Airport Technical  Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PWL",
                "sub_unit_code_doc" => "PWL.C.AA",
                "position_name" => "Airport Administration Coordinator",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.LC",
                "position_name" => "Legal, Compliance, and Stakeholder Relation Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.AF",
                "position_name" => "Airport Safety, Risk, and Performance Management Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.PR",
                "position_name" => "Procurement Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.R.AO",
                "position_name" => "Airport Operation, Services, Security, and Technical Senior Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.OS",
                "position_name" => "Airport Operation and Service Improvement Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.OR",
                "position_name" => "Airport Rescue, Fire Fighting, and Security Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.TF",
                "position_name" => "Airport Facilities Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.TE",
                "position_name" => "Airport Equipment Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.TI",
                "position_name" => "Airport Technology Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.R.AD",
                "position_name" => "Airport Commercial and Administration Senior Manager",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.DC",
                "position_name" => "Airport Commercial Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.DF",
                "position_name" => "Finance Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DHX",
                "sub_unit_code_doc" => "DHX.M.DH",
                "position_name" => "Human Capital Business Partner and General Services Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG V",
                "sub_unit_code_doc" => "UPR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.V.AF",
                "position_name" => "Airport Safety, Risk, & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OL",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "UPG",
                "sub_unit_code_doc" => "UPG.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.V.AO",
                "position_name" => "Airport Operation, Services, Security & Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.OL",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.OF",
                "position_name" => "Airport Facilities, Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "AMQ",
                "sub_unit_code_doc" => "AMQ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "MDC",
                "sub_unit_code_doc" => "MDC.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.P.AO",
                "position_name" => "Airport Operation, Service, Security & Safety Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.P.AF",
                "position_name" => "Airport Facilities, Equipment, & Technology Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.P.AC",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BIK",
                "sub_unit_code_doc" => "BIK.P.AP",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.LS",
                "position_name" => "Legal, Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal, & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CR",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CO",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CN",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CB",
                "position_name" => "Cargo & Business Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "DJJ",
                "sub_unit_code_doc" => "DJJ.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.CEO",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.D.ROS",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "",
                "position_name" => "Airport Operation & Services Quality Assurance & Improvement",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.D.RAC",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.D.RFT",
                "position_name" => "Deputy Regional Airport Facility, Equipment, & Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.D.RAM",
                "position_name" => "Deputy Regional Finance, Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "REG VI",
                "sub_unit_code_doc" => "BPR.D.RHB",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OL",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OS",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OP",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.OC",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.CN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.DH",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BPN",
                "sub_unit_code_doc" => "BPN.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.AF",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.AQ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.TA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.TL",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PNK",
                "sub_unit_code_doc" => "PNK.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.LC",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.SR",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.PR",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.V.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.FM",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.FQ",
                "position_name" => "Quality, Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.FE",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.V.AC",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.CA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.CN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.V.AD",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.DF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.DA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.DH",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "BDJ",
                "sub_unit_code_doc" => "BDJ.P.DG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.GM",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.PL",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.AF",
                "position_name" => "Airport Safety, Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.OC",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.V.AO",
                "position_name" => "Airport Operation, Services & Security Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.OA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.OL",
                "position_name" => "Airport Operation Landside, Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.OR",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.OS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.V.AT",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.TF",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.TE",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.TI",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.V.AC",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.CC",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.CF",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.CA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.CH",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "branch_code" => "PKY",
                "sub_unit_code_doc" => "PKY.P.CR",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ]
        ];

        foreach ($positions as $position) {
            Position::where('branch_code', $position['branch_code'])
                ->where(function ($q) use ($position) {
                    $q->where('sub_unit_code_doc', $position['sub_unit_code_doc'])
                        ->orWhere('position_name', $position['position_name']);
                })
                ->update([
                    'assigned_roles' => $position['assigned_roles']
                ]);
        }
    }
}
