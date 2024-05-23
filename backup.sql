CREATE TABLE public.product_types (
	id serial NOT NULL,
	"type" varchar NOT NULL,
	tax float4 NOT NULL,
	CONSTRAINT product_types_pk PRIMARY KEY (id)
);

CREATE TABLE public.products (
	id serial NOT NULL,
	product_type_id int NOT NULL,
	"name" varchar NOT NULL,
	value decimal NOT NULL,
	CONSTRAINT products_pk PRIMARY KEY (id),
	CONSTRAINT products_product_types_fk FOREIGN KEY (product_type_id) REFERENCES public.product_types(id)
);

CREATE TABLE public.orders (
	id serial NOT NULL,
	total_without_tax decimal NOT NULL,
	total_percentage decimal NOT NULL,
	total_with_tax decimal NOT NULL,
	total_products int NOT NULL,
	created_at timestamp NOT NULL,
	CONSTRAINT orders_pk PRIMARY KEY (id)
);

CREATE TABLE public.order_product (
	id serial NOT NULL,
	order_id int NOT NULL,
	product_id int NOT NULL,
	qtd int NULL,
	tax float4 NOT NULL,
	total_without_tax decimal NOT NULL,
	total_percentage decimal NOT NULL,
	total_with_tax decimal NOT NULL,
	unitary_value decimal NOT NULL,
	CONSTRAINT order_product_pk PRIMARY KEY (id),
	CONSTRAINT order_product_orders_fk FOREIGN KEY (order_id) REFERENCES public.orders(id),
	CONSTRAINT order_product_products_fk FOREIGN KEY (product_id) REFERENCES public.products(id)
);