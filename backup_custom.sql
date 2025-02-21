PGDMP      -                }            desafio_soft_expert    17.2    17.2 B    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    24576    desafio_soft_expert    DATABASE     �   CREATE DATABASE desafio_soft_expert WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.utf8';
 #   DROP DATABASE desafio_soft_expert;
                     postgres    false            �            1259    24578    product_types    TABLE     D  CREATE TABLE public.product_types (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);
 !   DROP TABLE public.product_types;
       public         heap r       postgres    false            �            1259    24577    product_types_id_seq    SEQUENCE     }   CREATE SEQUENCE public.product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.product_types_id_seq;
       public               postgres    false    218            �           0    0    product_types_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.product_types_id_seq OWNED BY public.product_types.id;
          public               postgres    false    217            �            1259    24617    products    TABLE     �  CREATE TABLE public.products (
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
    DROP TABLE public.products;
       public         heap r       postgres    false            �            1259    24616    products_id_seq    SEQUENCE     x   CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.products_id_seq;
       public               postgres    false    222            �           0    0    products_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;
          public               postgres    false    221            �            1259    24649    qa_product_types    TABLE     G  CREATE TABLE public.qa_product_types (
    id bigint NOT NULL,
    uuid character varying(36) NOT NULL,
    deleted smallint DEFAULT 0,
    active smallint DEFAULT 1,
    name character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);
 $   DROP TABLE public.qa_product_types;
       public         heap r       postgres    false            �            1259    24648    qa_product_types_id_seq    SEQUENCE     �   CREATE SEQUENCE public.qa_product_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.qa_product_types_id_seq;
       public               postgres    false    226            �           0    0    qa_product_types_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.qa_product_types_id_seq OWNED BY public.qa_product_types.id;
          public               postgres    false    225            �            1259    24676    qa_products    TABLE     �  CREATE TABLE public.qa_products (
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
    DROP TABLE public.qa_products;
       public         heap r       postgres    false            �            1259    24675    qa_products_id_seq    SEQUENCE     {   CREATE SEQUENCE public.qa_products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.qa_products_id_seq;
       public               postgres    false    230            �           0    0    qa_products_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.qa_products_id_seq OWNED BY public.qa_products.id;
          public               postgres    false    229            �            1259    24692    qa_sales    TABLE     q  CREATE TABLE public.qa_sales (
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
    DROP TABLE public.qa_sales;
       public         heap r       postgres    false            �            1259    24691    qa_sales_id_seq    SEQUENCE     x   CREATE SEQUENCE public.qa_sales_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.qa_sales_id_seq;
       public               postgres    false    232            �           0    0    qa_sales_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.qa_sales_id_seq OWNED BY public.qa_sales.id;
          public               postgres    false    231            �            1259    24660    qa_taxes    TABLE     {  CREATE TABLE public.qa_taxes (
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
    DROP TABLE public.qa_taxes;
       public         heap r       postgres    false            �            1259    24659    qa_taxes_id_seq    SEQUENCE     x   CREATE SEQUENCE public.qa_taxes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.qa_taxes_id_seq;
       public               postgres    false    228            �           0    0    qa_taxes_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.qa_taxes_id_seq OWNED BY public.qa_taxes.id;
          public               postgres    false    227            �            1259    24633    sales    TABLE     n  CREATE TABLE public.sales (
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
    DROP TABLE public.sales;
       public         heap r       postgres    false            �            1259    24632    sales_id_seq    SEQUENCE     u   CREATE SEQUENCE public.sales_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.sales_id_seq;
       public               postgres    false    224            �           0    0    sales_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.sales_id_seq OWNED BY public.sales.id;
          public               postgres    false    223            �            1259    24601    taxes    TABLE     x  CREATE TABLE public.taxes (
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
    DROP TABLE public.taxes;
       public         heap r       postgres    false            �            1259    24600    taxes_id_seq    SEQUENCE     u   CREATE SEQUENCE public.taxes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.taxes_id_seq;
       public               postgres    false    220            �           0    0    taxes_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.taxes_id_seq OWNED BY public.taxes.id;
          public               postgres    false    219            �           2604    24581    product_types id    DEFAULT     t   ALTER TABLE ONLY public.product_types ALTER COLUMN id SET DEFAULT nextval('public.product_types_id_seq'::regclass);
 ?   ALTER TABLE public.product_types ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    218    218            �           2604    24620    products id    DEFAULT     j   ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);
 :   ALTER TABLE public.products ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    221    222            �           2604    24652    qa_product_types id    DEFAULT     z   ALTER TABLE ONLY public.qa_product_types ALTER COLUMN id SET DEFAULT nextval('public.qa_product_types_id_seq'::regclass);
 B   ALTER TABLE public.qa_product_types ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    225    226    226            �           2604    24679    qa_products id    DEFAULT     p   ALTER TABLE ONLY public.qa_products ALTER COLUMN id SET DEFAULT nextval('public.qa_products_id_seq'::regclass);
 =   ALTER TABLE public.qa_products ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    229    230    230            �           2604    24695    qa_sales id    DEFAULT     j   ALTER TABLE ONLY public.qa_sales ALTER COLUMN id SET DEFAULT nextval('public.qa_sales_id_seq'::regclass);
 :   ALTER TABLE public.qa_sales ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    232    231    232            �           2604    24663    qa_taxes id    DEFAULT     j   ALTER TABLE ONLY public.qa_taxes ALTER COLUMN id SET DEFAULT nextval('public.qa_taxes_id_seq'::regclass);
 :   ALTER TABLE public.qa_taxes ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    227    228            �           2604    24636    sales id    DEFAULT     d   ALTER TABLE ONLY public.sales ALTER COLUMN id SET DEFAULT nextval('public.sales_id_seq'::regclass);
 7   ALTER TABLE public.sales ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    223    224    224            �           2604    24604    taxes id    DEFAULT     d   ALTER TABLE ONLY public.taxes ALTER COLUMN id SET DEFAULT nextval('public.taxes_id_seq'::regclass);
 7   ALTER TABLE public.taxes ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    219    220    220            y          0    24578    product_types 
   TABLE DATA           `   COPY public.product_types (id, uuid, deleted, active, name, created_at, updated_at) FROM stdin;
    public               postgres    false    218   RR       }          0    24617    products 
   TABLE DATA           x   COPY public.products (id, uuid, deleted, active, name, price, amount, product_type, created_at, updated_at) FROM stdin;
    public               postgres    false    222   �S       �          0    24649    qa_product_types 
   TABLE DATA           c   COPY public.qa_product_types (id, uuid, deleted, active, name, created_at, updated_at) FROM stdin;
    public               postgres    false    226   $W       �          0    24676    qa_products 
   TABLE DATA           {   COPY public.qa_products (id, uuid, deleted, active, name, price, amount, product_type, created_at, updated_at) FROM stdin;
    public               postgres    false    230   �W       �          0    24692    qa_sales 
   TABLE DATA           u   COPY public.qa_sales (id, uuid, deleted, active, product_id, sell_price, amount, created_at, updated_at) FROM stdin;
    public               postgres    false    232   X       �          0    24660    qa_taxes 
   TABLE DATA           n   COPY public.qa_taxes (id, uuid, deleted, active, name, tax, product_type, created_at, updated_at) FROM stdin;
    public               postgres    false    228   #X                 0    24633    sales 
   TABLE DATA           r   COPY public.sales (id, uuid, deleted, active, product_id, sell_price, amount, created_at, updated_at) FROM stdin;
    public               postgres    false    224   �X       {          0    24601    taxes 
   TABLE DATA           k   COPY public.taxes (id, uuid, deleted, active, name, tax, product_type, created_at, updated_at) FROM stdin;
    public               postgres    false    220   �Y       �           0    0    product_types_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.product_types_id_seq', 8, true);
          public               postgres    false    217            �           0    0    products_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.products_id_seq', 14, true);
          public               postgres    false    221            �           0    0    qa_product_types_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.qa_product_types_id_seq', 16, true);
          public               postgres    false    225            �           0    0    qa_products_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.qa_products_id_seq', 13, true);
          public               postgres    false    229            �           0    0    qa_sales_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.qa_sales_id_seq', 1, false);
          public               postgres    false    231            �           0    0    qa_taxes_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.qa_taxes_id_seq', 11, true);
          public               postgres    false    227            �           0    0    sales_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.sales_id_seq', 5, true);
          public               postgres    false    223            �           0    0    taxes_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.taxes_id_seq', 10, true);
          public               postgres    false    219            �           2606    24587     product_types product_types_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.product_types
    ADD CONSTRAINT product_types_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.product_types DROP CONSTRAINT product_types_pkey;
       public                 postgres    false    218            �           2606    24626    products products_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.products DROP CONSTRAINT products_pkey;
       public                 postgres    false    222            �           2606    24658 &   qa_product_types qa_product_types_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.qa_product_types
    ADD CONSTRAINT qa_product_types_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.qa_product_types DROP CONSTRAINT qa_product_types_pkey;
       public                 postgres    false    226            �           2606    24685    qa_products qa_products_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.qa_products
    ADD CONSTRAINT qa_products_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.qa_products DROP CONSTRAINT qa_products_pkey;
       public                 postgres    false    230            �           2606    24701    qa_sales qa_sales_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.qa_sales
    ADD CONSTRAINT qa_sales_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.qa_sales DROP CONSTRAINT qa_sales_pkey;
       public                 postgres    false    232            �           2606    24669    qa_taxes qa_taxes_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.qa_taxes
    ADD CONSTRAINT qa_taxes_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.qa_taxes DROP CONSTRAINT qa_taxes_pkey;
       public                 postgres    false    228            �           2606    24642    sales sales_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.sales DROP CONSTRAINT sales_pkey;
       public                 postgres    false    224            �           2606    24610    taxes taxes_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.taxes
    ADD CONSTRAINT taxes_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.taxes DROP CONSTRAINT taxes_pkey;
       public                 postgres    false    220            �           2606    24627 #   products products_product_type_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.product_types(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.products DROP CONSTRAINT products_product_type_fkey;
       public               postgres    false    218    222    4818            �           2606    24686 )   qa_products qa_products_product_type_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.qa_products
    ADD CONSTRAINT qa_products_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.qa_product_types(id) ON DELETE CASCADE;
 S   ALTER TABLE ONLY public.qa_products DROP CONSTRAINT qa_products_product_type_fkey;
       public               postgres    false    226    230    4826            �           2606    24702 !   qa_sales qa_sales_product_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.qa_sales
    ADD CONSTRAINT qa_sales_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.qa_products(id) ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.qa_sales DROP CONSTRAINT qa_sales_product_id_fkey;
       public               postgres    false    4830    232    230            �           2606    24670 #   qa_taxes qa_taxes_product_type_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.qa_taxes
    ADD CONSTRAINT qa_taxes_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.qa_product_types(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.qa_taxes DROP CONSTRAINT qa_taxes_product_type_fkey;
       public               postgres    false    228    226    4826            �           2606    24643    sales sales_product_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.sales
    ADD CONSTRAINT sales_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;
 E   ALTER TABLE ONLY public.sales DROP CONSTRAINT sales_product_id_fkey;
       public               postgres    false    4822    224    222            �           2606    24611    taxes taxes_product_type_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.taxes
    ADD CONSTRAINT taxes_product_type_fkey FOREIGN KEY (product_type) REFERENCES public.product_types(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.taxes DROP CONSTRAINT taxes_product_type_fkey;
       public               postgres    false    220    218    4818            y   �  x�m�;�S1�k�Ud�Ѽ�J	����֍D)��!*
*�A6�u�(����,�7���0eD��@�"��!�ZA���:r￶�����]= ����(<cke��;��u	
�A�̀�Q+Q��u��m�Tm"P���0I�E\QL&5��ke�P�*`�-u���_�wv�7�s�ۡ�]��/
�=ckbJC�k�!�x$��A,��J�J�enߞ_���e���,�$,�������Et� ɓ@�>����.������f�4ckE��s��h�1��BÄ��Z=��k��?�ϓ�ue�Ft��I��\�j�uh��0N��%+�Q(����Ɇ���r�Y|��5�>-�Y0������7����)�&�v�����k1��}��˗uY��B���      }     x�m�M��6���)�Lt$@ޥ�&��S�������n��n�r�$���/X�ʹ�Q�a���Di�����I,�,���^;�@�8��c=�����`29f�D�'������j��#G�)�h[D}!��\�?5K�C/����|'ǿdl}���y�Ǘn"9�Ik���.RD�C0�CUeq�bѵl�<XJ����/��i:��l�y�K{�[���!h���ѢWr��n��)AL��r�~^�9����Dg6��'|��r�)��L�w�6��XNL6�Z�*�ï�_�yT�A�*�&3l0C��"�M���n!T��?mq�[�05?QO��,�˵�2?�d=�H@����j�L	�h_@�dJVfl6ä��|�^S��};�6�L ���Ž[	��v�G���� Y�d�;��e�T�*7����ܝ���婟O�b2_�c]3�j��� ;IF��A��f�VR#��)%B�[F?\��D�zy��<˃��Xƻeڇ����$un�FS0�J�����&��d���������^�����q��r<݋��b������Ox��J�NM�brі�or�>䢆��eA<.F�i�Ej�R��f �=h�*�[,�-�)۪�BJ�k]X��ݍ5��7~w~����u�9Cy-0�qC ���K��@̺���fK�Q u�Z�_��.r5#��[�:���e�6S�N��MP�d�:�k0�`KO��e�����~���Ǧo>���7ѹ�÷F���mގZ���w�0��o      �   b   x�mȻ�0�Z����'�X0E
�T�&�O��Y ����m����M�� �W�1���-H���ʯ��땗��IE�2<�f-��7L����R��b      �   `   x�mȱ�  �:���%� 0����
��)��~��ՅZ+�5:�3E�B��"A����\��M�ａ����������L���h㨸�� s�      �      x������ � �      �   Z   x�mȱ�0КL��>BtK���p|���=��8��ڸ4=��������Z�uO���8>+��R&�E}���U4H�rJ�q�+         �   x�m���!EcQ�6�9���Z6f迄��F�$�wu��O���ȼЮ�uԌ��ڒ�@���j  $�$�����|H�ˎ06mE�������6���yU�n�����D������U��E����3p���Rw}Ǩm�R��Qh�z'�7\�C*�K1P��C��M<p��x���م�x3D��~�=�����܊��u��FsI�6�l��U^�����v!���TمNw�aI�U~�R�I�g�      {   �  x�m�;��0�k�� R$%���� �*m�u�#��7k�cc>�M!WS�l��
�G���e3�x�V1`����@�jH�0�7J;ў����tT"�����I`}��\��� !��E�I�-k�0����Х�ICKsB�]X�	M� �oA�(�n��I�M�E	���X(s�1��.��J���#_��@��j�v�'m3�(j�Ĥ)�ҳ���鏰J��$�y���|9ܚI;�69�M29$������`�g�����fZ��>^_�=�Eo��f��ı��]ܫ�NvJb�$x@�S�z����r�E_y��1�ږ�j�X�����~^�	s����'���-�!b���{��;���g�h��2��}�G�=�}Qc$��Z�W�����g�[��e�JYR$���E���à�!9���Hi��U����mh���E�-W���-���dҳ     