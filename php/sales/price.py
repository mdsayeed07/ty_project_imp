quantity = int(input("Enter Quantity: "))
mrp = int(input("Enter MRP: "))
disc = float(input("Enter Discount (%): "))
sp = int(input("Enter Selling Price: "))
gst = int(input("Enter GST (%): "))
print("\n")
total_quan = quantity*mrp
disc_price = total_quan*(disc/100)
cost_price = total_quan - disc_price
print("Cost Price=",cost_price)
total_sp = sp*quantity
disc_sp = total_sp*(disc/100)
selling_price = total_sp - disc_sp
print("Selling Price =",selling_price)

gprofit = selling_price-cost_price
print("Gross Profit =",gprofit)

nprofit = gprofit-(gprofit*gst/100)
print("Net Profit =",nprofit)
