"""
SQLAlchemy models phản ánh các bảng trong database MySQL.
"""
from sqlalchemy import create_engine, Column, Integer, String, Float, Text, ForeignKey
from sqlalchemy.orm import declarative_base, sessionmaker, relationship
from config import SQLALCHEMY_DATABASE_URI

engine = create_engine(SQLALCHEMY_DATABASE_URI, echo=False, pool_recycle=3600)
SessionLocal = sessionmaker(bind=engine)
Base = declarative_base()


class User(Base):
    __tablename__ = 'users'

    id = Column(Integer, primary_key=True)
    email = Column(String(255))
    password = Column(String(255))
    role = Column(String(50))
    google_id = Column(String(255))
    avatar = Column(String(255))
    cart_data = Column(Text)

    orders = relationship('Order', back_populates='user')


class Category(Base):
    __tablename__ = 'categories'

    id = Column(Integer, primary_key=True)
    name = Column(String(255))

    products = relationship('Product', back_populates='category')


class Product(Base):
    __tablename__ = 'products'

    id = Column(Integer, primary_key=True)
    name = Column(String(255))
    slug = Column(String(255))
    description = Column(Text)
    image = Column(String(500))
    price = Column(Float)
    quanlity = Column(Integer)
    view = Column(Integer)
    category_id = Column(Integer, ForeignKey('categories.id'))

    category = relationship('Category', back_populates='products')
    order_details = relationship('OrderDetail', back_populates='product')


class Order(Base):
    __tablename__ = 'order'

    id = Column(Integer, primary_key=True)
    code = Column(String(50))
    status = Column(String(50))
    user_id = Column(Integer, ForeignKey('users.id'))
    first_name = Column(String(100))
    last_name = Column(String(100))
    email = Column(String(255))
    phone = Column(String(20))
    address = Column(String(255))
    city = Column(String(100))
    zip = Column(String(20))
    total_price = Column(Float)

    user = relationship('User', back_populates='orders')
    details = relationship('OrderDetail', back_populates='order')


class OrderDetail(Base):
    __tablename__ = 'order_details'

    id = Column(Integer, primary_key=True)
    quanlity = Column(Integer)
    price = Column(Float)
    order_detailscol = Column(String(255))
    order_id = Column(Integer, ForeignKey('order.id'))
    product_id = Column(Integer, ForeignKey('products.id'))

    order = relationship('Order', back_populates='details')
    product = relationship('Product', back_populates='order_details')
