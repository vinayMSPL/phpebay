USE [EWS]
GO

/****** Object:  Table [dbo].[eBayShippingdetails]    Script Date: 09/26/2012 23:16:59 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[eBayShippingdetails](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[EnvironmentID] [int] NULL,
	[SiteID] [int] NULL,
	[ItemDBID] [int] NULL,
	[ItemID] [nvarchar](48) NULL,
	[AllowPaymentEdit] [int] NULL,
	[ApplyShippingDiscount] [int] NULL,
	[CSR_OriginatingPostalCode] [nvarchar](16) NULL,
	[CSR_PackageDepth] [float] NULL,
	[CSR_PackageDepthUnit] [nvarchar](16) NULL,
	[CSR_PackageLength] [float] NULL,
	[CSR_PackageLengthUnit] [nvarchar](16) NULL,
	[CSR_PackageWidth] [float] NULL,
	[CSR_PackageWidthUnit] [nvarchar](16) NULL,
	[CSR_PackageHandlingCosts] [money] NULL,
	[CSR_ShippingIrregular] [int] NULL,
	[CSR_ShippingPackage] [nvarchar](32) NULL,
	[CSR_WeightMajor] [float] NULL,
	[CSR_WeightMajorUnit] [nvarchar](16) NULL,
	[CSR_WeightMinor] [float] NULL,
	[CSR_WeightMinorUnit] [nvarchar](16) NULL,
	[CarrierShippingFee] [money] NULL,
	[ChangePaymentInstructions] [int] NULL,
	[InsuranceFee] [money] NULL,
	[InsuranceOption] [nvarchar](32) NULL,
	[InsuranceTotal] [money] NULL,
	[InsuranceWanted] [int] NULL,
	[PaymentInstructions] [ntext] NULL,
	[SalesTaxPercent] [float] NULL,
	[SalesTaxState] [nvarchar](16) NULL,
	[SalesTaxAmount] [money] NULL,
	[ShippingIncludedInTax] [int] NULL,
	[SellerPostalCode] [nvarchar](16) NULL,
	[ShippingRateErrorMsg] [ntext] NULL,
	[ShippingRateType] [nvarchar](32) NULL,
	[ShippingType] [nvarchar](32) NULL,
	[SSO1_ShippingInsuranceCost] [money] NULL,
	[SSO1_ShippingService] [nvarchar](64) NULL,
	[SSO1_ShippingServiceCost] [money] NULL,
	[SSO1_AdditionalCost] [money] NULL,
	[SSO2_ShippingInsuranceCost] [money] NULL,
	[SSO2_ShippingService] [nvarchar](64) NULL,
	[SSO2_ShippingServiceCost] [money] NULL,
	[SSO2_AdditionalCost] [money] NULL,
	[SSO3_ShippingInsuranceCost] [money] NULL,
	[SSO3_ShippingService] [nvarchar](64) NULL,
	[SSO3_ShippingServiceCost] [money] NULL,
	[SSO3_AdditionalCost] [money] NULL,
	[ISSO1_ShippingService] [nvarchar](64) NULL,
	[ISSO1_ShippingServiceCost] [money] NULL,
	[ISSO1_AdditionalCost] [money] NULL,
	[ISSO1_ShipToLocation] [nvarchar](48) NULL,
	[ISSO2_ShippingService] [nvarchar](64) NULL,
	[ISSO2_ShippingServiceCost] [money] NULL,
	[ISSO2_AdditionalCost] [money] NULL,
	[ISSO2_ShipToLocation] [nvarchar](48) NULL,
	[ISSO3_ShippingService] [nvarchar](64) NULL,
	[ISSO3_ShippingServiceCost] [money] NULL,
	[ISSO3_AdditionalCost] [money] NULL,
	[ISSO3_ShipToLocation] [nvarchar](48) NULL,
	[SSO1_ShippingSurcharge] [money] NULL,
	[SSO2_ShippingSurcharge] [money] NULL,
	[SSO3_ShippingSurcharge] [money] NULL,
	[InternationalInsuranceFee] [money] NULL,
	[InternationalInsuranceOption] [nvarchar](32) NULL,
 CONSTRAINT [PK_eBay_shippingdetails] PRIMARY KEY NONCLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

ALTER TABLE [dbo].[eBayShippingdetails]  WITH CHECK ADD  CONSTRAINT [FK_eBay_shippingdetails_eBay_items] FOREIGN KEY([ItemDBID])
REFERENCES [dbo].[eBayItems] ([ID])
GO

ALTER TABLE [dbo].[eBayShippingdetails] CHECK CONSTRAINT [FK_eBay_shippingdetails_eBay_items]
GO

