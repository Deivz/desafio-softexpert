--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2
-- Dumped by pg_dump version 17.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: product_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_types (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.product_types OWNER TO postgres;

--
-- Name: product_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_types_id_seq OWNER TO postgres;

--
-- Name: product_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_types_id_seq OWNED BY public.product_types.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    price bigint NOT NULL,
    amount bigint NOT NULL,
    product_type integer NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.products OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- Name: qa_product_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.qa_product_types (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.qa_product_types OWNER TO postgres;

--
-- Name: qa_product_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.qa_product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.qa_product_types_id_seq OWNER TO postgres;

--
-- Name: qa_product_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.qa_product_types_id_seq OWNED BY public.qa_product_types.id;


--
-- Name: qa_products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.qa_products (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    price bigint NOT NULL,
    amount bigint NOT NULL,
    product_type integer NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.qa_products OWNER TO postgres;

--
-- Name: qa_products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.qa_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.qa_products_id_seq OWNER TO postgres;

--
-- Name: qa_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.qa_products_id_seq OWNED BY public.qa_products.id;


--
-- Name: qa_sales; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.qa_sales (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    product_id bigint NOT NULL,
    sell_price bigint NOT NULL,
    amount bigint NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.qa_sales OWNER TO postgres;

--
-- Name: qa_sales_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.qa_sales_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.qa_sales_id_seq OWNER TO postgres;

--
-- Name: qa_sales_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.qa_sales_id_seq OWNED BY public.qa_sales.id;


--
-- Name: qa_taxes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.qa_taxes (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    tax integer NOT NULL,
    product_type bigint NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.qa_taxes OWNER TO postgres;

--
-- Name: qa_taxes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.qa_taxes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.qa_taxes_id_seq OWNER TO postgres;

--
-- Name: qa_taxes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.qa_taxes_id_seq OWNED BY public.qa_taxes.id;


--
-- Name: sales; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sales (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    product_id bigint NOT NULL,
    sell_price bigint NOT NULL,
    amount bigint NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.sales OWNER TO postgres;

--
-- Name: sales_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sales_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sales_id_seq OWNER TO postgres;

--
-- Name: sales_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sales_id_seq OWNED BY public.sales.id;


--
-- Name: taxes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.taxes (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    tax integer NOT NULL,
    product_type bigint NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.taxes OWNER TO postgres;

--
-- Name: taxes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.taxes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.taxes_id_seq OWNER TO postgres;

--
-- Name: taxes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.taxes_id_seq OWNED BY public.taxes.id;


--
-- Name: product_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_types ALTER COLUMN id SET DEFAULT nextval('public.product_types_id_seq'::regclass);


--
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- Name: qa_product_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_product_types ALTER COLUMN id SET DEFAULT nextval('public.qa_product_types_id_seq'::regclass);


--
-- Name: qa_products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_products ALTER COLUMN id SET DEFAULT nextval('public.qa_products_id_seq'::regclass);


--
-- Name: qa_sales id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_sales ALTER COLUMN id SET DEFAULT nextval('public.qa_sales_id_seq'::regclass);


--
-- Name: qa_taxes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_taxes ALTER COLUMN id SET DEFAULT nextval('public.qa_taxes_id_seq'::regclass);


--
-- Name: sales id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sales ALTER COLUMN id SET DEFAULT nextval('public.sales_id_seq'::regclass);


--
-- Name: taxes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.taxes ALTER COLUMN id SET DEFAULT nextval('public.taxes_id_seq'::regclass);


--
-- Data for Name: product_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_types (id, uuid, deleted, active, name, created_at, updated_at) FROM stdin;
1	0892300a-6016-4aa7-bfc0-a4ab0157f1c5	0	1	Eletrônicos	2025-02-14 12:09:32	2025-02-14 12:09:32.93425
2	259002ef-3364-45fa-b192-07e1eb73e55d	0	1	Bebidas	2025-02-14 12:09:44	2025-02-14 12:09:44.108371
3	b408a3d6-a4d8-422d-b21d-06ac8f406295	0	1	Cama, mesa e banho	2025-02-14 12:10:10	2025-02-14 12:10:10.821871
4	0d8fa069-3501-467b-9841-63a87debbcbb	0	1	Frutas	2025-02-14 12:10:24	2025-02-14 12:10:24.234836
5	5e8ea5d4-2b3a-4c26-8513-f757a36e2c13	0	1	Móveis	2025-02-14 12:10:28	2025-02-14 12:10:28.663734
6	10209fa9-bb4d-406f-b054-e080910da924	0	1	Eletrodomésticos	2025-02-14 12:10:34	2025-02-14 12:10:34.472846
7	2e9b9b9e-946f-4f66-9481-e8abfe16bbe7	0	1	Laticínios	2025-02-14 12:10:56	2025-02-14 12:10:56.864958
8	a6a172fb-a3fd-45e1-842d-18360a23c3da	0	1	Grãos	2025-02-14 12:11:07	2025-02-14 12:11:07.759374
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id, uuid, deleted, active, name, price, amount, product_type, created_at, updated_at) FROM stdin;
1	6ad9760c-e2fa-4383-934c-c51bece1635e	0	1	Microondas 10L	85099	16	6	2025-02-14 12:14:18	2025-02-14 12:14:18.626969
2	bcb63544-0239-48c8-a2fd-5a23eb12f628	0	1	Caixa de 1L de Leite	650	30	7	2025-02-14 12:14:42	2025-02-14 12:14:42.656448
3	c21cabec-4f1b-40d8-9521-03b6e04a115d	0	1	1Kg de Queijo Prato	4990	30	7	2025-02-14 12:15:04	2025-02-14 12:15:04.133437
4	a16a1f46-4221-496a-a11e-e0277167be2b	0	1	1kg de Laranja	298	60	4	2025-02-14 12:15:18	2025-02-14 12:15:18.868732
5	d106b200-d000-4cf1-9795-70cb95c4a04b	0	1	1kg de Tâmaras	4290	20	4	2025-02-14 12:15:38	2025-02-14 12:15:38.233695
6	d81d090e-13c6-4d81-b0be-a43fd2f5e125	0	1	Toalha de Rosto	2560	14	3	2025-02-14 12:15:55	2025-02-14 12:15:55.857435
7	d2f14165-d4a8-4d6d-81fc-c9d72c5ec7d6	0	1	Edredon	35066	10	3	2025-02-14 12:16:08	2025-02-14 12:16:08.450615
9	29e118a9-3498-4590-9a6e-993a75e11eca	0	1	Champagne Supernova	89099	4	2	2025-02-14 12:16:51	2025-02-14 12:16:51.301905
11	4e5a8402-d1d6-481c-a7d5-34aaf7754a4e	0	1	Guarda Roupa Casal	180000	14	5	2025-02-14 12:17:37	2025-02-14 12:17:37.173346
14	8c8a4659-36dd-4ce8-ac9f-4e4e0290252b	0	1	1kg de Feijão Carioquinha	698	4	8	2025-02-14 12:19:04	2025-02-14 12:19:27
12	f1bfbbae-ac72-4706-bc25-93e238b3699e	0	1	Cama de Casal	90000	6	5	2025-02-14 12:17:49	2025-02-14 12:19:34
13	a8e3a044-f1be-4b52-9ef8-c200f3774ecc	0	1	250g de Café Arábica	2690	58	8	2025-02-14 12:18:44	2025-02-14 12:19:51
10	789f3599-a170-4ded-b746-b1105e2dd66a	0	1	Celular 256Gb	165812	14	1	2025-02-14 12:17:19	2025-02-14 12:20:14
8	3a1a8484-c726-4df3-be79-9995ad15722a	0	1	Vinho do Porto (600mL)	45000	1	2	2025-02-14 12:16:35	2025-02-14 12:20:50
\.


--
-- Data for Name: qa_product_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.qa_product_types (id, uuid, deleted, active, name, created_at, updated_at) FROM stdin;
1	c43f78df-2b23-4310-8947-0682e314b6b8	0	1	Test Product Type	2025-02-14 13:25:27	2025-02-14 13:25:27.918115
\.


--
-- Data for Name: qa_products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.qa_products (id, uuid, deleted, active, name, price, amount, product_type, created_at, updated_at) FROM stdin;
1	52f38fff-8a93-410d-900e-a56e182bd665	0	1	Test Product	1500	10	1	2025-02-14 13:25:52	2025-02-14 13:25:52.095772
\.


--
-- Data for Name: qa_sales; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.qa_sales (id, uuid, deleted, active, product_id, sell_price, amount, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: qa_taxes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.qa_taxes (id, uuid, deleted, active, name, tax, product_type, created_at, updated_at) FROM stdin;
1	f2370b7e-c068-482c-bfe4-5724f0857517	0	1	Test Tax	1500	1	2025-02-14 13:25:39	2025-02-14 13:25:39.360801
\.


--
-- Data for Name: sales; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sales (id, uuid, deleted, active, product_id, sell_price, amount, created_at, updated_at) FROM stdin;
1	ad56e083-b99e-4ec5-96fb-39886664f279	0	1	14	1934	2	2025-02-14 12:19:27	2025-02-14 12:19:27.841437
2	1e90f77f-897b-4fcb-a1f6-4a498a5fcb59	0	1	12	99000	1	2025-02-14 12:19:34	2025-02-14 12:19:34.332611
3	4001d6c8-fbca-4938-a49a-867c1f312b86	0	1	13	7453	2	2025-02-14 12:19:51	2025-02-14 12:19:51.260952
4	343a1b37-357d-4258-b599-d54154da20bb	0	1	10	232136	1	2025-02-14 12:20:14	2025-02-14 12:20:14.593754
5	2cfdca88-40c6-43a8-a997-a9ba761fe37f	0	1	8	130500	2	2025-02-14 12:20:50	2025-02-14 12:20:50.490852
\.


--
-- Data for Name: taxes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.taxes (id, uuid, deleted, active, name, tax, product_type, created_at, updated_at) FROM stdin;
1	68954e39-5155-4cdc-a81e-53990c0acb80	0	1	ISG	1500	8	2025-02-14 12:11:26	2025-02-14 12:11:26.939459
2	5d81140b-bc3e-4df0-8de1-9cfd85375794	0	1	ISGC	2355	8	2025-02-14 12:11:44	2025-02-14 12:11:44.50965
3	e48344d6-c4c5-4c23-b2ee-c6c43544d1e3	0	1	ISBA	4500	2	2025-02-14 12:11:57	2025-02-14 12:11:57.409479
4	8a85f350-163b-45dd-8bc4-b7f2553393d6	0	1	ISM	1000	5	2025-02-14 12:12:09	2025-02-14 12:12:09.968991
5	5231526d-37c6-4dcb-b7f0-f77e9b46deab	0	1	ISF	523	4	2025-02-14 12:12:36	2025-02-14 12:12:36.461899
6	3eb5488b-f9dd-4b5b-852c-2861f8064fcd	0	1	ISFG	1300	4	2025-02-14 12:12:52	2025-02-14 12:12:52.995153
7	afcd0648-5e3d-4230-b70a-8ee4d59b4c32	0	1	ISE	4000	1	2025-02-14 12:13:08	2025-02-14 12:13:08.639871
8	03b2eb2c-8e8e-41c1-b337-bf00df6f0e0f	0	1	ISLA	1400	7	2025-02-14 12:13:24	2025-02-14 12:13:24.791305
9	3556353a-cf0d-46c2-b212-930139a89742	0	1	ISCMB	3000	3	2025-02-14 12:13:34	2025-02-14 12:13:34.981642
10	6a124231-34d7-4b09-a466-975c2747b00c	0	1	ISED	55	6	2025-02-14 12:13:51	2025-02-14 12:13:51.681461
\.


--
-- Name: product_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_types_id_seq', 8, true);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 14, true);


--
-- Name: qa_product_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.qa_product_types_id_seq', 16, true);


--
-- Name: qa_products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.qa_products_id_seq', 13, true);


--
-- Name: qa_sales_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.qa_sales_id_seq', 1, false);


--
-- Name: qa_taxes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.qa_taxes_id_seq', 11, true);


--
-- Name: sales_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sales_id_seq', 5, true);


--
-- Name: taxes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.taxes_id_seq', 10, true);


--
-- Name: product_types product_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_types
    ADD CONSTRAINT product_types_pkey PRIMARY KEY (id);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: qa_product_types qa_product_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_product_types
    ADD CONSTRAINT qa_product_types_pkey PRIMARY KEY (id);


--
-- Name: qa_products qa_products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_products
    ADD CONSTRAINT qa_products_pkey PRIMARY KEY (id);


--
-- Name: qa_sales qa_sales_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_sales
    ADD CONSTRAINT qa_sales_pkey PRIMARY KEY (id);


--
-- Name: qa_taxes qa_taxes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_taxes
    ADD CONSTRAINT qa_taxes_pkey PRIMARY KEY (id);


--
-- Name: sales sales_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_pkey PRIMARY KEY (id);


--
-- Name: taxes taxes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.taxes
    ADD CONSTRAINT taxes_pkey PRIMARY KEY (id);


--
-- Name: products products_product_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.product_types(id) ON DELETE CASCADE;


--
-- Name: qa_products qa_products_product_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_products
    ADD CONSTRAINT qa_products_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.qa_product_types(id) ON DELETE CASCADE;


--
-- Name: qa_sales qa_sales_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_sales
    ADD CONSTRAINT qa_sales_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.qa_products(id) ON DELETE CASCADE;


--
-- Name: qa_taxes qa_taxes_product_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.qa_taxes
    ADD CONSTRAINT qa_taxes_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.qa_product_types(id) ON DELETE CASCADE;


--
-- Name: sales sales_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- Name: taxes taxes_product_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.taxes
    ADD CONSTRAINT taxes_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.product_types(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

